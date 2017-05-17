<?php

namespace Baguette\Mastodon\Entity;

/**
 * Status
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#status
 * @property-read int      $id  The ID of the status
 * @property-read string   $uri A Fediverse-unique resource ID
 * @property-read string   $url URL to the status page (can be remote)
 * @property-read Account  $account The Account which posted the status
 * @property-read Attachments[] $media_attachments The Account which posted the status
 * @property-read int|null $in_reply_to_accountid  The ID of the status it replies to
 * @property-read int|null $in_reply_to_id The ID of the account it replies to
 * @property-read Status|null $reblog The reblogged Status
 * @property-read string   $content   Body of the status; this will contain HTML (remote HTML already sanitized)
 * @property-read \DateTimeImmutable $created_at The time the status was created
 * @property-read int    $reblogs_count    The number of reblogs for the status
 * @property-read int    $favourites_count The number of favourites for the status
 * @property-read bool   $reblogged    Whether the authenticated user has reblogged the status
 * @property-read bool   $favourited   Whether the authenticated user has favourited the status
 * @property-read string $sensitive    Whether media attachments should be hidden by default
 * @property-read string $spoiler_text If not empty, warning text that should be displayed before the actual content
 * @property-read string $visibility   One of: public, unlisted, private, direct
 * @property-read Attachment[] $media_attachments An array of Attachments
 * @property-read Mention[]    $mentions An array of Mentions
 * @property-read Tag[]        $tags     An array of Tags
 * @property-read Application  $application Application from which the status was posted
 */
class Status extends Entity
{
    use \Teto\Object\TypedProperty;

    private static $property_types = [
        'id'                => 'int',
        'uri'               => 'string',
        'url'               => 'string',
        'account'           => Account::class,
        'in_reply_to_id'    => '?int',
        'in_reply_to_account_id' => '?int',
        'reblog'            => Status::class,
        'content'           => 'string',
        'created_at'        => \DateTimeImmutable::class,
        'reblogs_count'     => 'int',
        'favourites_count'  => 'int',
        'reblogged'         => 'bool',
        'favourited'        => 'bool',
        'sensitive'         => 'bool',
        'spoiler_text'      => 'string',
        'visibility'        => 'enum',
        'media_attachments' => 'Baguette\Mastodon\Entity\Attachment[]',
        'mentions'          => 'Baguette\Mastodon\Entity\Mention[]',
        'tags'              => 'Baguette\Mastodon\Entity\Tag[]',
        'application'       => Application::class,
    ];

    private static $enum_values = [
        'visibility' => ['direct', 'private', 'unlisted', 'public'],
    ];

    public function __construct(array $properties)
    {
        if (isset($properties['account'])) {
            $properties['account'] = map (Account::class, $properties['account']);
        }
        if (isset($properties['reblog'])) {
            $properties['reblog'] = map(Status::class, $properties['reblog']);
        }
        if (isset($properties['created_at'])) {
            $properties['created_at'] = map(\DateTimeImmutable::class, $properties['created_at']);
        }
        if (isset($properties['media_attachments'])) {
            $properties['media_attachments'] = map([Attachment::class], $properties['media_attachments']);
        }
        if (isset($properties['mentions'])) {
            $properties['mentions'] = map([Mention::class], $properties['mentions']);
        }
        if (isset($properties['tags'])) {
            $properties['tags'] = map([Tag::class], $properties['tags']);
        }
        if (isset($properties['application'])) {
            $properties['application'] = map(Application::class, $properties['application']);
        }

        $this->setProperties($properties);
    }

    /**
     * Returns account data as array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'                => $this->id,
            'uri'               => $this->uri,
            'url'               => $this->url,
            'account'           => toArrayValue($this->account),
            'in_reply_to_id'    => $this->in_reply_to_id,
            'in_reply_to_account_id' => $this->in_reply_to_account_id,
            'reblog'            => toArrayValue($this->reblog),
            'content'           => $this->content,
            'created_at'        => toArrayValue($this->created_at),
            'reblogs_count'     => $this->reblogs_count,
            'favourites_count'  => $this->favourites_count,
            'reblogged'         => $this->reblogged,
            'favourited'        => $this->favourited,
            'sensitive'         => $this->sensitive,
            'spoiler_text'      => $this->spoiler_text,
            'visibility'        => $this->visibility,
            'media_attachments' => toArrayValue($this->media_attachments),
            'mentions'          => toArrayValue($this->mentions),
            'tags'              => toArrayValue($this->tags),
            'application'       => toArrayValue($this->application),
        ];
    }
}
