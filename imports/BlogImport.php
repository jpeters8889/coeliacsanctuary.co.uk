<?php

declare(strict_types=1);

namespace Imports;

use Coeliac\Common\Models\Image;
use Intervention\Image\ImageManager;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Blog\Models\BlogTag;

class BlogImport extends Import
{
    public function handle()
    {
        /** @var ImageManager $imageManager */
        $imageManager = app(ImageManager::class);

        $seeds = $this->seedDatabase->table('blogs')->where('live', 1)->get();

        $bar = $this->command->makeProgressBar(count($seeds));

        $bar->start();

        foreach ($seeds as $seed) {
            try {
                if (Blog::query()->where('slug', $seed->alias)->count() > 0) {
                    continue;
                }

                /** @var Blog $blog */
                $blog = Blog::query()->create([
                    'title' => stripslashes($seed->title),
                    'slug' => $seed->alias,
                    'description' => stripslashes($seed->longDesc),
                    'body' => stripslashes($seed->text),
                    'meta_tags' => stripslashes($seed->metaTags),
                    'meta_description' => stripslashes($seed->metaDesc),
                    'live' => $seed->live,
                    'created_at' => $seed->created_at,
                    'updated_at' => $seed->updated_at,
                ]);

                $imageAssociations = [];

                $imgSeeds = $this->seedDatabase->table('blog_images')->where('blogID', $seed->id)->get();

                foreach ($imgSeeds as $imgSeed) {
                    try {
                        $imageFilename = '/assets/images/blogs/'.$seed->alias.'/'.str_replace(' ', '%20', $imgSeed->image);

                        $imageManager->make('https://www.coeliacsanctuary.co.uk'.$imageFilename)
                            ->save($image = public_path('imports/'.$imgSeed->image));

                        switch ($imgSeed->type) {
                            case 'main':
                                $typeId = 2;
                                break;
                            case 'social':
                                $typeId = 3;
                                break;
                            default:
                                $typeId = 1;
                                break;
                        }

                        /** @var Image $newImage */
                        $newImage = Image::query()->create([
                            'file_name' => $this->uploadImage('blogs/'.$seed->alias, $image),
                            'directory' => 'blogs/'.$seed->alias,
                            'created_at' => $imgSeed->created_at,
                            'updated_at' => $imgSeed->updated_at,
                        ]);

                        $blog->associateImage($newImage, $typeId);

                        $imageAssociations[$imageFilename] = $newImage->image_url;
                        unlink($image);
                    } catch (\Exception $e) {
                    }
                }

                $tagSeeds = $this->seedDatabase->table('blog_tags')->where('blogID', $seed->id)->get();

                foreach ($tagSeeds as $tagSeed) {
                    $tag = BlogTag::query()->firstOrCreate([
                        'tag' => trim($tagSeed->tag),
                        'slug' => trim($tagSeed->tagSafe, " -\t\n\r\0\x0B"),
                    ], [
                        'created_at' => $tagSeed->created_at,
                        'updated_at' => $tagSeed->updated_at,
                    ]);

                    $blog->tags()->attach($tag);
                }

                $blog->update([
                   'body' => $this->formatHtml($blog->body, $blog->slug, $imageAssociations),
                ]);

                $bar->advance();
            } catch (\Exception $e) {
            }
        }

        $bar->finish();
    }
}
