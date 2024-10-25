<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\AddEditBookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('/', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/new', name: 'app_book_new')]
    public function newBook(Request $request, ManagerRegistry $doctrine){
        $book = new Book();
        //$book->setTitle('Abc'); //champs du formulaire pré-rempli
        $em= $doctrine->getManager();
        $form= $this->createForm(AddEditBookType::class, $book);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('app_book_list');
        }
        return $this->render('book/form.html.twig', [
            'title' => 'Add Book',
            'form' => $form
        ]);

    }

    #[Route('/edit/{ref}', name: 'app_book_edit')]
    public function editBook($ref, Request $request, ManagerRegistry $doctrine){
        $bookRepository = $doctrine->getRepository(Book::class);
        $book = $bookRepository->find($ref);
        $em= $doctrine->getManager();
        $form= $this->createForm(AddEditBookType::class, $book);
        //$form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            //$em->persist($book);
            $em->flush();
            return $this->redirectToRoute('app_book_list');
        }
        return $this->render('book/form.html.twig', [
            'title' => 'Update Book',
            'form' => $form
        ]);

    }

    #[Route('/list', name: 'app_book_list')]
    public function bookList(ManagerRegistry $doctrine){
        $bookRepository= $doctrine->getRepository(Book::class);
        $books= $bookRepository->findAll();
        return $this->render('book/list.html.twig',[
            'books' => $books
        ]);
    }

    #[Route('/details/{ref}', name: 'app_book_details')]
    public function bookDetails($ref, BookRepository $bookRepository){
        $book= $bookRepository->find($ref);
        //$book= $bookRepository->findByTitle('abcjkhj555');
        //dd($books);
        return $this->render('book/details.html.twig',[
            'book' => $book
        ]);
    }

    #[Route('/author', name: 'app_book_author')]
    public function BookJoinAuthor(BookRepository $bookRepository) {
        $books= $bookRepository->findBookAuthorDQL();
        dd($books);

    }

    #[Route('/delete/{ref}', name: 'app_book_delete')]
    public function deleteBook($ref, BookRepository $bookRepository, EntityManagerInterface $em){
        $book= $bookRepository->find($ref);
        $em->remove($book);
        $em->flush();
        return $this->redirectToRoute('app_book_list');
    }
}
