<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Services\FileUploader;
use App\Services\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * 
 * @Route("/post", name="post.")
 * @author Martin Seon
 * @package App\Controller
 */
class PostController extends AbstractController
{
    /**
     * 
     * @var PostRepository
     */
    private $postRepository;

    /**
     * Constructor
     * 
     * @author Martin Seon
     * @param PostRepository $postRepository 
     * @return void 
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @Route("/", name="index")
     * @return Response 
     */
    public function index(): Response
    {
        $posts = $this->postRepository->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @param FileUploader $fileUploader
     */
    public function create(Request $request, FileUploader $fileUploader, Notification $notification): Response
    {
        // create a new post with title
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // entity manager
            $em = $this->getDoctrine()->getManager();
            /** @var UploadedFile */
            $file = $request->files->get('post')['attachment'];

            if ($file) {
                $filename = $fileUploader->uploadFile($file);
                $post->setImage($filename);
                $em->persist($post);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('post.index'));
        }

        return $this->render('post/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     * @param Post $post
     * @return Response 
     */
    public function show(int $id): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $this->postRepository->find($id)
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @return Response 
     */
    public function remove(int $id): Response
    {
        $post = $this->postRepository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        $this->addFlash('success', 'Post was removed');

        return $this->redirect($this->generateUrl('post.index'));
    }
}
