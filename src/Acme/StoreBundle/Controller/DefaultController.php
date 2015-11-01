<?php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;

class DefaultController extends Controller
{
    /**
     * Стандартный контроллер
     *
     * @param $name
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($name)
    {
        return $this->render('AcmeStoreBundle:Default:index.html.twig', array('name' => $name));
    }

    /**
     * Добавление данных
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction() {
        $product = new Product();
        $product->setName('A Foo Bar');
        $product->setPrice('19.99');
        $product->setDescription("Lorem ipsum");

        //Менеджер ответственный за управление процессами сохранения и получения обьектов БД
        $em = $this->getDoctrine()->getManager();
        //Сообщает команду на "управление обьектом" $product
        $em->persist($product);
        //Просматривает все обьекты которыми управляет, чтобы узнать, надо ли сохранять их в БД и выполняет запросы
        $em->flush();
        return $this->render('AcmeStoreBundle:Default:insert.html.twig', array('id' => $product->getId()));
    }

    /**
     * Вывод всех данных из таблицы
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allAction() {
        $repository = $this->getDoctrine()
            ->getRepository('AcmeStoreBundle:Product');
        $products = $repository->findAll();
        return $this->render('AcmeStoreBundle:Default:all.html.twig', array('products' => $products));

    }
    //test
}
