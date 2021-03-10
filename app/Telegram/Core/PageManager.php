<?php


namespace App\Telegram\Core;


use App\Models\User;
use App\Telegram\Pages\User\HomePage;
use Telegram\Bot\Objects\Update;

class PageManager implements Manager
{
    private Update $update;
    private User $user;

    public $home = HomePage::class;

    /**
     * PageManager constructor.
     * @param $update
     * @param User $user
     */
    public function __construct(Update $update, User $user)
    {
        $this->update = $update;
        $this->user = $user;
    }

    public function show($page, $args = [])
    {
        if (!$page) return 'page is null';
        if (str_contains($page, 'Admin') && !$this->user->role !== 'admin') {
            return false;
        }
        $this->user->update(['page' => $page]);
        return $this->getPageInstance($page)->show($args);
    }

    public function handle()
    {
        $page = $this->getPageInstance($this->user->page);
        switch ($this->update->message->text) {
            case __('⬅️ Orqaga'):
                return $this->show($page->previous);
            case __('🏠 Bosh sahifa'):
                return $this->show($this->home);
        }
        return $page->handle();
    }

    private function getPageInstance($page): Page
    {
        if ($this->checkPage()) {
            return new $page($this->update, $this->user, $this);
        }
        $this->user->update(['page' => HomePage::class]);
        return new HomePage($this->update, $this->user, $this);
    }

    private function checkPage(): bool
    {
        return class_exists($this->user->page) && is_subclass_of($this->user->page, Page::class);
    }
}
