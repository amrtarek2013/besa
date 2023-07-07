<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class BlogsController extends AppController
{

    public function index()
    {
        $this->set('bodyClass', 'pageAbout');

        $blogs = $this->Blogs->find()->where(['active' => 1])->order(['display_order' => 'asc'])->limit(10)->all();

        $this->set('blogs', $blogs);
    }
    public function details($id = null)
    {
        $blog = $this->Blogs->findByPermalink($id)->first();

        // debug($blog);
        $this->set('bodyClass', 'pageUnitedKingdom pageServices');

        if (empty($blog))

            throw new NotFoundException(__('Not found'));

        $this->set('blog', $blog);
        $this->set('permalink', $id);

    }
}
