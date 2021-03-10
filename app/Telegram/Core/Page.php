<?php


namespace App\Telegram\Core;

use App\Models\User;
use Telegram\Bot\Objects\Update;

abstract class Page
{
    use HelperTrait;

    protected Update $update;
    protected User $user;
    protected PageManager $pageManager;

    public $next;
    public $previous;

    public $previousButton = true;
    public $homeButton = true;

    /**
     * Page constructor.
     * @param Update $update
     * @param User $user
     * @param PageManager $pageManager
     */
    public function __construct(Update $update, User $user, PageManager $pageManager)
    {
        $this->update = $update;
        $this->user = $user;
        $this->pageManager = $pageManager;
    }

    abstract public function show($args = []);

    abstract public function handle();

    protected function go($page, $args = [])
    {
        return $this->pageManager->show($page, $args);
    }

    protected function goNext($args = [])
    {
        return $this->pageManager->show($this->next, $args);
    }

    protected function goPrevious($args = [])
    {
        return $this->pageManager->show($this->previous, $args);
    }

    protected function goHome($args = [])
    {
        return $this->pageManager->show($this->pageManager->home, $args);
    }

    protected function goThis($args = [])
    {
        return $this->pageManager->show(static::class, $args);
    }
}
