<?php

namespace Pingu\Entity\Traits\Uris;

trait EntityUris
{
    public function index(): string
    {
        return $this->object::routeSlugs();
    }

    public function view(): string
    {
        return $this->object::routeSlug().'/{'.$this->object::routeSlug().'}';
    }

    public function create(): string
    {
    	return $this->object::routeSlugs().'/create';
    }

    public function store(): string
    {
    	return $this->object::routeSlugs();
    }

    public function confirmDelete(): string
    {
        return $this->object::routeSlug().'/{'.$this->object::routeSlug().'}/delete';
    }

    public function delete(): string
    {
        return $this->object::routeSlug().'/{'.$this->object::routeSlug().'}';
    }

    public function edit(): string
    {
        return $this->object::routeSlug().'/{'.$this->object::routeSlug().'}/edit';
    }

    public function update(): string
    {
        return $this->object::routeSlug().'/{'.$this->object::routeSlug().'}';
    }

    public function patch(): string
    {
        return $this->object::routeSlugs();
    }
}