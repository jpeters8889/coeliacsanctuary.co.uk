<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Order;

use Coeliac\Modules\Shop\Models\ShopOrderReviewInvitation;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class ShopOrderReviewInvitationModelTest extends TestCase
{
    /** @test */
    public function itCreatesAUuidWhenCreatingTheModel(): void
    {
        $invitation = ShopOrderReviewInvitation::query()->create(['order_id' => 1]);

        $this->assertNotNull($invitation->id);
        $this->assertIsString($invitation->id);
        $this->assertTrue(Uuid::isValid($invitation->id));
    }
}
