<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Controllers;

use Illuminate\Http\Request;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Blog\Requests\BlogShowRequest;

class BlogController extends BaseController
{
    private Page $page;

    private Repository $repository;

    public function __construct(Page $page, Repository $repository)
    {
        $this->page = $page;
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->page
            ->breadcrumbs([], 'Blogs')
            ->setPageTitle('Gluten Free Blogs')
            ->setMetaDescription('Coeliac Sanctuary gluten free blog list | All of our Coeliac blog posts in one list')
            ->setMetaKeywords(['coeliac sanctuary blog', 'blog index', 'index', 'blog list blog', 'blog tags', 'coeliac blog'])
            ->setSocialImage(asset('assets/images/shares/blog-list.jpg'))
            ->render('modules.blogs.index');
    }

    public function list(Request $request)
    {
        $this->validate($request, [
            'limit' => 'integer,max:50',
        ]);

        return [
            'data' => $this->repository
                ->setWithCounts(['comments'])
                ->setColumns(['id', 'title', 'slug', 'description', 'meta_description', 'created_at'])
                ->filter()
                ->search()
                ->paginated($request->get('limit', 12)),
        ];
    }

    public function show(BlogShowRequest $request)
    {
        /* @var Blog $blog */
        abort_if(!$blog = $request->resolveItem(), 404, 'Sorry, this blog can\'t be found');

        $related = $blog->tags()
            ->first()
            ->blogs()
            ->where('id', '!=', $blog->id)
            ->where('live', true)
            ->with('images', 'images.image')
            ->latest()
            ->take(10)
            ->get();

        if (!$related) {
            $related = (new Repository())->random()->take(10);
        }

        return $this->page
            ->breadcrumbs([
                [
                    'link' => '/blog',
                    'title' => 'Blogs',
                ],
            ], $blog->title)
            ->setPageTitle($blog->title.' | Blogs')
            ->setMetaDescription($blog->meta_description)
            ->setMetaKeywords(explode(',', (string) $blog->meta_keywords))
            ->setSocialImage($blog->social_image)
            ->render('modules.blogs.show', compact('blog', 'related'));
    }
}
