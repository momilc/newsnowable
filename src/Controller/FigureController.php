<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Figure;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;


class FigureController extends Controller
{
    /**
     * @Route("/figure", name="figure")
     * @param RegistryInterface $em
     * @return Response
     */
    public function index(RegistryInterface $em): Response
    {
        $figures = $em->getRepository(Figure::class)->findAll();
        $categories = $em->getRepository(Category::class)->findAll();
        return $this->render('figure/figurePage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__), 'figure' => $figures, 'categories' => $categories]);
    }

    /**
     * @Route("/add_figure", name="add_figure")
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function addFigure(EntityManagerInterface $entityManager): Response
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
        $category = new Category();
        $category->setName('Grabs Goofy');
        $figure = new Figure();
        $figure->setName('Le Grab');
        $figure->setTypeTrick('mute');
        $figure->setStyle('GooFy');
        $figure->setDescription('Un grab consiste à attraper la planche avec la main pendant le saut. Le grab de style mute consite à saisir la carre frontside de la planche entre les deux pieds avec la main avant. Style du rider : Goofy signifie que le rider aura son pied droit devant. On dit Style Goofy ou Switch.');
        // relate this product to the category
        $figure->setCategory($category);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($figure);
        $entityManager->persist($category);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return new Response('Saved new product with id '.$figure->getId(). ' and new Category with id: ' .$category->getId());
    }

    /**
     * @Route("/figure/{id}", name="figure_show")
     * @param $id
     * @return Response
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \LogicException
     * @throws NonUniqueResultException
     */
    public function showAction($id): Response
    {
        $figure = $this->getDoctrine()
            ->getRepository(Figure::class)
            ->findOneByIdJoinedToCategory($id);

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneByIdJoinedToFigure($id);

        if (!$figure){
            throw $this->createNotFoundException(
                'No Figure found for id ' .$id
            );
        }

        return new Response('
            <p>Figure :</p>
            <p>Nom : ' . $figure->getName(). '</p>
            <p>Type de Trick : '.$figure->getTypeTrick().'</p>
            <p>Style de la Figure : '.$figure->getStyle().'</p>
            <p>Description :</p>' . $figure->getDescription().'</p>
            <p>Catégorie :<br/> '.$category->getName().'</p>'
        );
        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }

    //Updating an object

    /**
     * @Route("/figure/edit/{id}")
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     * @throws \LogicException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws NonUniqueResultException
     */
    public function updateAction($id, EntityManagerInterface $entityManager): RedirectResponse
    {
        $figure = $entityManager
            ->getRepository(Figure::class)
            ->findOneByIdJoinedToCategory($id);

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneByIdJoinedToFigure($id);

        if (!$figure) {
            throw $this->createNotFoundException(
                'No Figure Found for id' .$figure->getName() .$category->getName()
            );
        }

        $figure->setName('New Figure name!');
        $category->setName('Real New Category');
        $entityManager->flush();

        return $this->redirectToRoute('figure_show', [
            'id' => $figure->getId(),
            'category' => $category->getId()
        ]);

    }
}
