<?php

namespace Amethyst\Permissions;

use Amethyst\Managers\PermissionManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Railken\Template\Generators;
use Symfony\Component\Yaml\Yaml;

class PermissionDictionary implements PermissionDictionaryContract
{
    /**
     * @var \Railken\Template\Generators\TextGenerator
     */
    protected $template;

    /**
     * @var \Amethyst\Managers\PermissionManager
     */
    protected $manager;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $permissions;

    /**
     * @var string
     */
    protected $wildcard = '*';

    /**
     * Create a new instance.
     */
    public function __construct()
    {
        $this->template = new Generators\TextGenerator();
        $this->manager = new PermissionManager();
        $this->permissions = Collection::make();
    }

    /**
     * @return Generators\TextGenerator
     */
    public function getTemplate(): Generators\TextGenerator
    {
        return $this->template;
    }

    /**
     * Boot all permissions.
     */
    public function boot()
    {
        $this->permissions = $this->manager->getRepository()->findBy([])->map(function ($permission) {
            $payload = Yaml::parse($permission->payload, Yaml::PARSE_OBJECT_FOR_MAP);

            $permission->parsed = $payload;

            return $permission;
        });
    }

    /**
     * Retrieve user.
     *
     * @return Model
     */
    public function getAgent(): Model
    {
        return Auth::user();
    }

    /**
     * @param mixed $attr
     *
     * @return array
     */
    public function parsePayload($attr): array
    {
        return !is_array($attr) ? [$attr] : $attr;
    }

    /**
     * Get wildcard.
     *
     * @return string
     */
    public function getWildcard(): string
    {
        return $this->wildcard;
    }

    public function getPermissionsByType(array $types): Collection
    {
        return $this->permissions->filter(function ($permission) use ($types) {
            return in_array($permission->type, $types, true);
        });
    }
}
