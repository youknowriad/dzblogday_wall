<?php

namespace Rizeway\RizewayWallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;


/**
 * Rizeway\RizewayWallBundle\Entity\Element
 */
class Element
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $email
     */
    private $email;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var string $description
     */
    private $description;

    /**
     * @var string $photo
     */
    private $photo;

    /**
     * @var string $link
     */
    private $link;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set photo
     *
     * @param UploadedFile $photo
     */
    public function setPhoto(UploadedFile $photo)
    {
        $this->photo = $this->uploadFile($photo);
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set link
     *
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }
    /**
     * @var boolean $approved
     */
    private $approved = false;


    /**
     * Set approved
     *
     * @param boolean $approved
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;
    }

    /**
     * Get approved
     *
     * @return boolean 
     */
    public function getApproved()
    {
        return $this->approved;
    }
    
    /**
     * @param UploadedFile $file
     * 
     * @return string $filename 
     */
    private function uploadFile(UploadedFile $file)
    {
        $filename  = md5(microtime());
        $upload_dir = __DIR__.'/../../../../web/uploads';

        // Fix the picture
        $imagine = new Imagine();
        $imagine->open($file->getPathname())
            ->thumbnail(new Box(500, 500), ImageInterface::THUMBNAIL_OUTBOUND)
            ->save($upload_dir.'/'.$filename.'.jpg');

        return 'uploads/'.$filename.'.jpg';
    }
}