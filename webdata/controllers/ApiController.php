<?php

class ApiController extends Pix_Controller
{
    public function init()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET');
    }

    public function countyAction()
    {
        return $this->json(Vote::getCounties());
    }

    public function townAction()
    {
        return $this->json(Vote::getTowns());
    }

    public function partyAction()
    {
        return $this->json(Vote::getParties());
    }

    public function dataAction()
    {
        list(, /*api*/, /*data*/, $id) = explode('/', $this->getURI());
        return $this->json(json_decode(VoteData::find($id)->data));
    }

    public function candidateAction()
    {
        list(, /*api*/, /*candidate*/, $id) = explode('/', $this->getURI());
        return $this->json(Candidate::findCandidateByVoteId($id));
    }

}
