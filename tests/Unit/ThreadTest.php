<?php
namespace Tests\Unit;

use App\Channel;
use App\Notifications\ThreadWasUpdated;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseTransactions;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    public function test_a_thread_has_replies()
    {
       $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
   }

   public function test_thread_has_creator()
   {
    $this->assertInstanceOf('App\User' , $this->thread->creator);
    }

    public function test_a_thread_can_make_a_string_paht()
    {
        $thread = create('App\Thread');

        $this->assertEquals("/threads/{$thread->channel->slug }/{$thread->id}" , $thread->path());
    }

    public function test_a_thread_can_add_reply()
    {
        $this->thread->addReply([
            'body' => 'Foo',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function test_a_thread_belong_to_a_channel()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel' , $thread->channel);
    }

    public function test_a_thread_belongs_to_a_channel()
    {
        $thread = create(Thread::class);

        $this->assertInstanceOf(Channel::class , $thread->channel);

    }

    public function test_can_add_subscribe_thread()
    {
        $thread = create(Thread::class);

        $thread->subscribe($userId = 1);

        $this->assertEquals(
            1,
            $thread->subscriptions()->where('user_id' ,$userId)->count()    
        );

            $subsInDB = $thread->subscriptions;
            
         $this->assertEquals($thread->id , $subsInDB[0]->thread_id);

         $this->assertEquals($userId , $subsInDB[0]->user_id);

         $this->assertDatabaseHas('thread_subscribes', ['thread_id' => $subsInDB[0]->thread_id]);

         $this->assertDatabaseHas('thread_subscribes', ['user_id' => $subsInDB[0]->user_id]);
    }

    public function test_can_unsubscribe_thread()
    {
        $thread = create(Thread::class);

        $thread->unsubscribe($userId = 999);

        $this->assertEquals(
            0,
            $thread->subscriptions()->where('user_id' ,$userId)->count()    
        );

         $this->assertDatabaseMissing('thread_subscribes', ['thread_id' => $thread->id]);
         
         $this->assertDatabaseMissing('thread_subscribes', ['user_id' => $userId]);
    }

    public function test_a_thread_notifies_all_registered_subdcribers_when_a_reply_is_added()
    {
        Notification::fake();

        $this->signIn();

        $this->thread->subscribe();

        $this->thread->addReply([
           'body' => 'Foobar',
           'user_id' => 1
        ]);

        Notification::assertSentTo(auth()->user() , ThreadWasUpdated::class);
    }

}
