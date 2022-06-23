<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/',methods: 'GET', name: 'app_main')]
    public function index(): Response
    {
        $sex = ['M','K'];
        $schoolclass = ['A','B','C','D','E','F'];


        return $this->render('index.html.twig', [
            'class' => $sex, 'school' => $schoolclass    ]);
    }
    #[Route('/result',methods: 'POST', name: 'app_show')]
    public function show(TeacherRepository $teacherRepository, StudentRepository $studentRepository): Response
    {
        $choose_querry= $_POST['query'];

        switch ($choose_querry)
        {
            case 1:
                $stud_sex = $_POST['stud_sex'];
                $school_class = $_POST['school_class'];
                $querry_result = $studentRepository->get_All_Students_from_Class_Sorted_by_Sex($school_class,$stud_sex);
                $page_twig = 'students.html.twig';
                $caption_tab = 'Uczniowie z klasy '.$school_class.' posortowani po płci';
                break;
            case 2:
                $querry_result = $teacherRepository->getAllTutorsWithSchoolClass();
                $page_twig = 'tutor.html.twig';
                $caption_tab = 'Wychowawcy wszystkich klas';
                break;
            case 3:
                $school_class = $_POST['school_class'];
                $querry_result = $studentRepository->getAllStudentsfromClass($school_class);
                $page_twig = 'students.html.twig';
                $caption_tab = 'Uczniowie z klasy '.$school_class;
                break;
            default:
                echo 'Nie ma takiej opcji'; break;
        }

        return $this->render($page_twig, [
            'result_table' => $querry_result, 'caption_tab' => $caption_tab
        ]);
    }
}
