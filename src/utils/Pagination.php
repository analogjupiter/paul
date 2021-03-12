<?php

declare(strict_types=1);

namespace Voidblaster\Paul\Utils;

use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

final class Pagination
{
    public function __construct(
        private int $offset,
        private int $limit,
    ) {
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public static function fromRequest(Request $request, int $defaultLimit = 20, int $maxLimit = 500): Pagination
    {
        $get = $request->getQueryParams();

        v::keyNested(
            'page.offset',
            v::intVal()->not(v::negative()),
            false
        )->keyNested(
            'page.limit',
            v::intVal()->not(v::negative())->max($maxLimit),
            false
        )->check($get);

        $offset = $get['page']['offset'] ?? 0;
        $limit = $get['page']['limit'] ?? $defaultLimit;

        return new Pagination((int)$offset, (int)$limit);
    }
}
