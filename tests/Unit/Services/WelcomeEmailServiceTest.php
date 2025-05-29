<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Services\WelcomeEmailService;

class WelcomeEmailServiceTest extends TestCase
{
    public function test_build_message_returns_correct_text()
    {

        $user = new User([
            'firstname' => 'Anna',
            'lastname' => 'Nowak',
        ]);

        $service = new WelcomeEmailService();

        $message = $service->buildMessage($user);

        $this->assertEquals('Welcome Anna Nowak!', $message);

    }
}
