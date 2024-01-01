<?php
declare(strict_types=1);

namespace RecipeManager\Database\Repositories;

use Exception;
use RecipeManager\Database\Models\Source;
use RecipeManager\Database\Models\SourceType;

final class SourceRepository extends Repository
{

    #[\Override] public function get(int $id)
    {
        $sql = "SELECT id,
       name,
       type
FROM source
WHERE source.id = ?
LIMIT 1";

        $result = $this->database->query($sql, $id);
        if (!$result) {
            throw new Exception("Couldn't query for source with id '$id'");
        }

        $valueArray = $result->fetch();
        if (!$valueArray) {
            return null;
        }

        return $this->createModel($valueArray);
    }

    public function getAll()
    {
        $sql = "SELECT 
    id, name, type
FROM source";

        $result = $this->database->query($sql);
        if (!$result) {
            throw new Exception("Couldn't query for recipes");
        }

        $resultingData = [];
        while ($row = $result->fetch()) {
            $resultingData[] = $this->createModel($row);
        }

        return $resultingData;
    }

    /**
     * @param array{id: int, name: string, type: string} $values
     */
    #[\Override] public function createModel(array $values): Source
    {
        return new Source(
            $values['id'],
            $values['name'],
            SourceType::from($values['type'])
        );
    }
}