<?php

declare(strict_types=1);

namespace Tests\Abstracts;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Common\Repositories\AbstractRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class RepositoryTest extends TestCase
{
    use RefreshDatabase;

    /*** @var AbstractRepository */
    protected AbstractRepository $repository;

    /** @var array<Model> */
    protected $models;

    abstract protected function loadRepository(): AbstractRepository;

    abstract protected function model(): string;

    protected function factoryParameters(): array
    {
        return [];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->loadRepository();

        $this->models = factory($this->model(), 5)->create($this->factoryParameters());
    }

    /** @test */
    public function itGetsASingleValue()
    {
        $this->assertInstanceOf($this->model(), $this->repository->get(1));
        $this->assertTrue($this->models[0]->is($this->repository->get(1)));
    }

    /** @test */
    public function itGetsATotalNumberOfRows()
    {
        $this->assertEquals(count($this->models), $this->repository->count());
    }

    /** @test */
    public function itReturnsALimitedSubsetOfRows()
    {
        $this->assertEquals(2, $this->repository->take(2)->count());
    }

    /** @test */
    public function itGetsAllRecords()
    {
        $this->assertEquals(count($this->models), $this->repository->all()->count());
    }

    /** @test */
    public function itLoadsAPaginatedListOfResources()
    {
        $resources = $this->repository->paginated(2);

        $this->assertInstanceOf(LengthAwarePaginator::class, $resources);
        $this->assertEquals(3, $resources->lastPage());
        $this->assertEquals(2, $resources->perPage());
    }

    /** @test */
    public function itCanLimitTheColumns()
    {
        $model = $this->repository
            ->setColumns(['id'])
            ->get(1);

        $this->assertNotNull($model->id);
        $this->assertNull($model->created_at);
    }

    /** @test */
    public function itCanUseARawQuery()
    {
        $model = $this->repository
            ->raw(function ($query) {
                $this->assertInstanceOf(Builder::class, $query);

                return $query->where('id', 1);
            })
            ->first();

        $this->assertInstanceOf($this->model(), $model);
        $this->assertEquals(1, $model->id);
    }

    /** @test */
    public function itCanAddWheres()
    {
        $attribute = array_keys($this->models[0]->attributesToArray())[0];

        $this->models[0]->update([$attribute => 'foobarbaz']);

        $this->assertEquals(1, $this->repository->where($attribute, 'foobarbaz')->all()->count());
    }
}
