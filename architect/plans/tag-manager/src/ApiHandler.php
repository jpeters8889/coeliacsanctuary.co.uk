<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\TagManager;

use Illuminate\Http\Request;
use Coeliac\Modules\Blog\Models\BlogTag;
use Illuminate\Contracts\Validation\Factory;

class ApiHandler
{
    public function search(Request $request, Factory $validator)
    {
        $validator->validate($request->all(), [
            'tagSource' => 'required',
            'searchTerm' => 'required',
        ]);

        switch ($request->input('tagSource')) {
            case 'blogTags':
                return BlogTag::query()
                    ->where('tag', 'LIKE', "%{$request->input('searchTerm')}%")
                    ->take(10)
                    ->orderBy('tag')
                    ->get()
                    ->transform(static function (BlogTag $tag) {
                        return $tag->tag;
                    });
        }

        abort(422, 'Tag Source not found');
    }
}
