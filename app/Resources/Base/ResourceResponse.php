<?php

namespace App\Resources\Base;

use Illuminate\Http\Resources\Json\ResourceResponse as JsonResourceResponse;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;

class ResourceResponse extends JsonResourceResponse
{
    /**
     * @inheritDoc
     * @param array|Collection $data
     */
    protected function wrap($data, $with = [], $additional = []): array
    {
        if ($data instanceof Collection) {
            $data = $data->all();
        }

        $wrapper = $this->wrapper();
        $dataIsUnwrapped = $this->haveDefaultWrapperAndDataIsUnwrapped($data);
        $dataHasAdditionalInfo = $this->haveAdditionalInformationAndDataIsUnwrapped($data, $with, $additional);

        if ($dataIsUnwrapped) {
            $data = [$wrapper => $data];
        } elseif ($dataHasAdditionalInfo) {
            $data = [$wrapper => $data];
        }

        if (empty($data[$wrapper]) &&
            !$this->resource->resource instanceof Collection &&
            !$this->resource->resource instanceof AbstractPaginator &&
            !$this->resource->resource instanceof AbstractCursorPaginator
        ) {
            $data[$wrapper] = (object) [];
        }

        return array_merge_recursive($data, $with, $additional);
    }
}
