<?php

namespace App\Models;

use App\Telegram\Core\Page;
use App\Telegram\Pages\StartPage;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed chat_id
 * @property Page page
 * @property mixed language
 */
class User extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'chat_id';

    public $incrementing = false;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'page' => StartPage::class,
        'language' => 'uz-Latn-UZ'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
