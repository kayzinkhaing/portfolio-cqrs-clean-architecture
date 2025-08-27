<?php

namespace App\Repositories;

class ProjectRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(modelName: 'Project');
    }

    public function createWithRelations(array $data)
    {
        // take out technologies from payload
        $techIds = $data['technology_ids'] ?? [];
        unset($data['technology_ids']);

        // create project using BaseRepository::create()
        $project = parent::create($data);

        // sync technologies if provided
        if (!empty($techIds)) {
            $this->syncOrDetachRelationship($project, 'technologies', $techIds, true);
        }

        return $project->load('technologies');
    }

    public function updateWithRelations(int $id, array $data)
    {
        $techIds = $data['technology_ids'] ?? [];
        unset($data['technology_ids']);

        // update base fields
        $project = parent::update($id, $data);

        // sync pivot
        if (!empty($techIds)) {
            $this->syncOrDetachRelationship($project, 'technologies', $techIds, true);
        }

        return $project->load('technologies');
    }
}
