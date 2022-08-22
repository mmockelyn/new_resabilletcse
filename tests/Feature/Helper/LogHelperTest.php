<?php

namespace Tests\Feature\Helper;

use App\Helper\LogHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogHelperTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_notify()
    {
        $notify = LogHelper::notify('critical', 'Testing');

        $this->assertEquals('Testing', $notify);
    }
}
