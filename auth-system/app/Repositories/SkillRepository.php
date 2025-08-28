<?php
namespace App\Repositories;

class SkillRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(modelName: 'Skill');
    }

    public function createWithRelations(array $data)
    {
        $skill = parent::create($data);
        return $skill->load('category'); // corrected relationship name
    }

    public function updateWithRelations(int $id, array $data)
    {
        $skill = parent::update($id, $data);
        return $skill->load('category'); // corrected relationship name
    }
}
