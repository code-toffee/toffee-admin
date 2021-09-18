<?php
declare(strict_types=1);

namespace App\Utils;

use Exception;

class TreeBuildUtils
{
    private array $data;

    private int $pid;

    private string $mappingIndex;

    private ?string $pidCall;

    private ?string $indexCall;

    private ?string $storeCall;

    private ?bool $storeMapData = null;

    private ?array $mapData = null;

    public function getMapData(): ?array
    {
        return $this->mapData;
    }

    public function setStoreMapData(?bool $storeMapData): self
    {
        $this->storeMapData = $storeMapData;
        return $this;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function setPid(int $pid): self
    {
        $this->pid = $pid;
        return $this;
    }

    public function setMappingIndex(string $mappingIndex): self
    {
        $this->mappingIndex = $mappingIndex;
        return $this;
    }

    public function setPidCall(?string $pidCall): self
    {
        $this->pidCall = $pidCall;
        return $this;
    }

    public function setIndexCall(?string $indexCall): self
    {
        $this->indexCall = $indexCall;
        return $this;
    }

    public function setStoreCall(?string $storeCall): self
    {
        $this->storeCall = $storeCall;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function objectBuildTree(): array
    {
        [
            'index'     => $index,
            'pid'       => $pid,
            'pidCall'   => $pidCall,
            'indexCall' => $indexCall,
            'storeCall' => $storeCall,
        ] = $this->preInspection();

        $data = $this->data;
        $tree = [];
        if (empty($data)) {
            return $tree;
        }
        $mapList = array_column($data, null, $index);
        if ($this->storeMapData) {
            $this->mapData = $mapList;
        }
        foreach ($mapList as $value) {
            if ($pid == $value->$pidCall()) {
                $tree[] = $mapList[$value->$indexCall()];
            } elseif (isset($mapList[$value->$pidCall()])) {
                $mapList[$value->$pidCall()]->$storeCall($mapList[$value->$indexCall()]);
            }
        }
        return $tree;
    }

    /**
     * @throws Exception
     */
    private function preInspection(): array
    {
        $params = [
            'index'     => $this->mappingIndex,
            'pid'       => $this->pid,
            'pidCall'   => $this->pidCall,
            'indexCall' => $this->indexCall,
            'storeCall' => $this->storeCall,
        ];
        foreach ($params as $key => $value) {
            if (!isset($value)) {
                throw new Exception("$key 未设置");
            }
        }

        return $params;
    }

    /**
     * @throws Exception
     */
    public function arrayBuildTree(): array
    {
        [
            'index'     => $index,
            'pid'       => $pid,
            'pidCall'   => $pidCall,
            'indexCall' => $indexCall,
            'storeCall' => $storeCall,
        ] = $this->preInspection();

        $data = $this->data;
        $tree = [];
        if (empty($data)) {
            return $tree;
        }
        $mapList = array_column($data, null, $index);
        if ($this->storeMapData) {
            $this->mapData = $mapList;
        }
        foreach ($mapList as $value) {
            if ($pid == $value[$pidCall]) {
                $tree[] = &$mapList[$value[$indexCall]];
            } elseif (isset($mapList[$value[$pidCall]])) {
                $mapList[$value[$pidCall]][$storeCall][] = &$mapList[$value[$indexCall]];
            }
        }
        return $tree;
    }
}
