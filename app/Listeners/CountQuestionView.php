<?php

namespace App\Listeners;

use App\Events\QuestionView;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Session\Store;

class CountQuestionView
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(QuestionView $event)
    {
        if(!$this->isQuestionViewed($event->question)){
            $event->question->update(['views_count' => (int)($event->question->views_count) + 1]);
            $this->storeQuestion($event->question);
        }
    }

    private function isQuestionViewed($question)
	{
	    $viewed = $this->session->get('viewed_questions', []);

	    return array_key_exists($question->id, $viewed);
	}

	private function storeQuestion($question)
	{
	    $key = 'viewed_questions.' . $question->id;

	    $this->session->put($key, time());
	}
}
