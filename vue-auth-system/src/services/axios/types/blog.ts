export interface BlogData {
  title: string;
  content: string;
}

export interface Blog {
  id: number;
  title: string;
  content: string;
  authorId: number;
  createdAt: string;
  updatedAt: string;
}

export interface BlogResponse {
  data: Blog[];
  total: number;
  page: number;
  limit: number;
}
