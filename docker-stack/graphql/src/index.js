import { MongoClient, ObjectId } from "mongodb";
import { ApolloServer } from "@apollo/server";
import { expressMiddleware } from "@apollo/server/express4";
import express from "express";
import cors from "cors";
import bodyParser from "body-parser";

const mongoUrl = process.env.MONGO_URL || "mongodb://localhost:27017";
const dbName = process.env.MONGO_DB || "read_model";

const typeDefs = `#graphql
  scalar Date

  type User {
    id: ID!
    name: String!
    email: String!
    createdAt: Date
    updatedAt: Date
  }

  type Query {
    users(limit: Int = 20, search: String): [User!]!
    user(id: ID!): User
  }
`;

const resolvers = {
  Query: {
    users: async (_parent, { limit, search }, { db }) => {
      const filter = search
        ? { $or: [{ name: { $regex: search, $options: "i" } }, { email: { $regex: search, $options: "i" } }] }
        : {};
      const docs = await db.collection("users").find(filter).limit(Math.min(limit, 200)).toArray();
      return docs.map(m2gUser);
    },
    user: async (_parent, { id }, { db }) => {
      const doc = await db.collection("users").findOne({ _id: new ObjectId(id) });
      return doc ? m2gUser(doc) : null;
    },
  },
};

function m2gUser(doc) {
  return {
    id: doc._id.toString(),
    name: doc.name,
    email: doc.email,
    createdAt: doc.created_at || doc.createdAt || null,
    updatedAt: doc.updated_at || doc.updatedAt || null,
  };
}

async function start() {
  const client = new MongoClient(mongoUrl);
  await client.connect();
  const db = client.db(dbName);

  const server = new ApolloServer({ typeDefs, resolvers });
  await server.start();

  const app = express();
  app.use(cors());
  app.use(bodyParser.json());
  app.use("/graphql", expressMiddleware(server, { context: async () => ({ db }) }));

  const port = 4000;
  app.listen({ port }, () => {
    console.log(`GraphQL ready at http://localhost:${port}/graphql`);
  });
}

start().catch((e) => {
  console.error(e);
  process.exit(1);
});
