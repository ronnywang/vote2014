<?php

class IndexController extends Pix_Controller
{
    public function indexAction()
    {
    }

    public function voteAction()
    {
        list(, /*index*/, /*key*/, $type) = explode('/', $this->getURI());
        if (!$name = Vote::getVoteTypes()[$type]) {
            return $this->redirect('/');
        }
        $this->view->name = $name;
        $this->view->type = $type;
    }

    public function vote2Action()
    {
        list(, /*index*/, /*vote2*/, $type, $provence_county) = explode('/', $this->getURI());
        if (!$name = Vote::getVoteTypes()[$type]) {
            return $this->redirect('/');
        }
        $this->view->name = $name;
        $this->view->type = $type;
        $this->view->keys = VoteData::getVoteIds($type, $provence_county);
    }

    public function dataAction()
    {
        list(, /*index*/, /*data*/, $id) = explode('/', $this->getURI());
        if (!$data = VoteData::find($id)) {
            return $this->redirect('/');
        }
        $this->view->data = $data;
    }
}
