<?php

namespace Pingu\Entity\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Forms\AddEntityForm;
use Pingu\Entity\Http\Requests\StoreEntityRequest;
use Pingu\Forms\Support\Form;

class BundledEntityController extends BaseController
{
    /**
     * Show the form for creating a new resource.
     * 
     * @param Request $request
     * @param string  $bundle
     *
     * @return View
     */
    public function create(Request $request, string $bundle)
    {
        $bundle = \Bundle::get($bundle);
        $form = $this->getAddForm($bundle);

        return view('entity::addEntity')->with([
            'form' => $form,
            'bundle' => $bundle
        ]);
    }

    protected function getAddForm(BundleContract $bundle): Form
    {
        return new AddEntityForm($bundle, $this->getStoreUri($bundle));
    }

    protected function getStoreUri(BundleContract $bundle): array
    {
        return ['url' => adminPrefix().replaceUriSlugs(\Entity::storeEntityUri(), [$bundle->name()])];
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param Request $request
     * @return Response
     */
    public function store(StoreEntityRequest $request)
    {
        $validated = $request->validated();

        $entity = $request->getBundle()->createEntity($validated);

        \Notify::success($entity->bundle()->bundleFriendlyName()." has been created");

        return $request->getBundle()->redirectAfterEntityCreation($entity);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function edit(Request $request, Content $content)
    {
        $form = new EditContentForm($content);

        return view('content::editContent')->with([
            'form' => $form,
            'title' => 'Edit '.$content->title,
            'contentType' => $content->content_type,
            'content' => $content,
            'deleteUri' => $content::makeUri('delete', [$content])
        ]);
    }

    /**
     * Updates a content
     * @param Request $request
     * @return Response
     */
    public function update(UpdateContentRequest $request, Content $content)
    {
        $validated = $request->validated();

        $content = \Content::updateContent($content, $validated);

        \Notify::success($content->content_type->name.' '.$content->fieldTitle." has been updated");

        return redirect()->route('content.admin.content');
    }
}