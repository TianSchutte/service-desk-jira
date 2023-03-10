<?php

namespace TianSchutte\ServiceDeskJira\Contracts;

interface IssueManagerInterface
{
    public function getIssue(string $issueKey);
    public function createIssue(array $data);
    public function updateIssue(string $issueKey, array $data);
    public function deleteIssue(string $issueKey);
    public function addAttachment(string $issueKey,array $data);
    public function addComment(string $issueKey,  array $data);

}
