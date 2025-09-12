<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(modelName: 'Project');
    }

    /**
     * Create a project with pivot relations (technologies) dynamically
     */
    public function createWithRelations(array $data)
    {
        // dd($data);
        $techIds = $data['technology_ids'] ?? [];
        // dd($techIds);
        unset($data['technology_ids']);

        // Create project via BaseRepository
        $project = parent::create($data);

        // Sync many-to-many relationship
        if (!empty($techIds)) {
            $this->syncOrDetachRelationship($project, 'technologies', $techIds, true);
        }
        // dd($project->load('technologies', 'status'));

        // Eager load relationships
        return $project->load('technologies', 'status');
    }

    /**
     * Update a project with pivot relations (technologies)
     */
    public function updateWithRelations(int $id, array $data)
    {
        $techIds = $data['technology_ids'] ?? [];
        unset($data['technology_ids']);

        // Update base fields
        $project = parent::update($id, $data);

        // Sync pivot relation
        if (!empty($techIds)) {
            $this->syncOrDetachRelationship($project, 'technologies', $techIds, true);
        }

        // Eager load relations dynamically
        return $project->load('technologies', 'status');
    }

    /**
     * Optional: Fetch projects with all relations (for read model / GraphQL)
     */
    public function allWithRelations()
    {
        return Project::with(['technologies', 'status'])->withTrashed()->get();
    }
    public function findWithRelations(int $id)
    {
        return Project::with(['technologies', 'status'])->findOrFail($id);
    }

}
