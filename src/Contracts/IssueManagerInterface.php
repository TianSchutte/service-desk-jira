<?php

namespace TianSchutte\ServiceDeskJira\Contracts;
/**
 * Interface defining methods for managing issues.
 */
interface IssueManagerInterface
{
    /**
     * Returns the issue of the specified key.
     * @param string $issueKey - The key of the issue to retrieve.
     * @return mixed
    */
    public function getIssue(string $issueKey);

    /**
     * Creates a new issue with the specified data and returns it.
     * @param array $data - The data to create the issue.
     * @return mixed
     */
    public function createIssue(array $data);

    /**
     * Updates the issue with the specified key with the new data.
     * @param string $issueKey - The key of the issue to update.
     * @param array $data - The new data to update the issue with.
     * @return mixed - The updated issue.
     */
    public function updateIssue(string $issueKey, array $data);

    /**
     * Adds an attachment to the issue with the specified key.
     * @param string $issueKey - The key of the issue to add the attachment.
     * @param array $data - The data of the attachment.
     * @return mixed  - The newly added attachment.
     */
    public function addAttachment(string $issueKey, array $data);

    /**
     * Adds a comment to the issue with the specified key.
     * @param string $issueKey - The key of the issue to add the comment.
     * @param array $data - The data of the comment.
     * @return mixed - The newly added comment.
     */
    public function addComment(string $issueKey, array $data);

    /**
     * Returns an array of comments for the issue with the specified key.
     * @param string $issueKey - The key of the issue to retrieve comments.
     * @return mixed - comments for the issue with the specified key.
     */
    public function getComments(string $issueKey);

    /**
     * Attaches a temporary file to be used for attachments.
     * @param mixed $file - The temporary file to attach.
     * @return mixed
     */
    public function attachTemporaryFile($file);

}
