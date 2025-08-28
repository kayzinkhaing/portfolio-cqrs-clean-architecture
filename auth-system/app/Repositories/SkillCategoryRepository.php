<?php
namespace App\Repositories;

class SkillCategoryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(modelName: 'SkillCategory');
    }

    // Example if you have relations (like skills under categories)
    public function createWithRelations(array $data)
    {
        $skills = $data['skill_ids'] ?? [];
        unset($data['skill_ids']);

        $category = parent::create($data);

        if (!empty($skills)) {
            $this->syncOrDetachRelationship($category, 'skills', $skills, true);
        }

        return $category->load('skills');
    }

    public function updateWithRelations(int $id, array $data)
    {
        $skills = $data['skill_ids'] ?? [];
        unset($data['skill_ids']);

        $category = parent::update($id, $data);

        if (!empty($skills)) {
            $this->syncOrDetachRelationship($category, 'skills', $skills, true);
        }

        return $category->load('skills');
    }
}
