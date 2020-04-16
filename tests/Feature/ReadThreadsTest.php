<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    private $thread;

    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();

    }


    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function a_user_can_read_a_single_thread()
    {

        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /**
     * @test
     */

    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'Miniyan']));
        $threadByMiniyan = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByMiniyan = create('App\Thread');
        $this->get('/threads?by=Miniyan')
            ->assertSee($threadByMiniyan->title)
            ->assertDontSee($threadNotByMiniyan->title);
    }

    /** @test */
    public function a_can_filter_threads_by_popularity()
    {
        $threadwithTwoReply = create('App\Thread');
        create('App\Reply',['thread_id' => $threadwithTwoReply->id],2);

        $threadwithThreeReply = create('App\Thread');
        create('App\Reply',['thread_id' => $threadwithThreeReply->id],3);

        $threadWithNoReplies = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();
        $this->assertEquals([3,2,0],array_column($response,'replies_count'));
    }
}
