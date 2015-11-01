<?php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
//use Symfony\Component\HttpFoundation\Response; //Без профайлера
use Symfony\Component\BrowserKit\Response; //С профайлером

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
        dump($name);
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

    /**
     * Обновление записи
     *
     * @param $id
     * @return Response
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AcmeStoreBundle:Product')->find($id);
        dump($product);
        if (!$product) {
            throw $this->createNotFoundException('No product found ' . $id);
        }
        $product->setName('New product name!');
        $em->flush();
        return new Response('Updated');
    }

    /**
     * Удаление записи
     *
     * @param $id
     * @return Response
     */
    public function removeAction($id) {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AcmeStoreBundle:Product')->find($id);
        if (!$product) {
            throw $this->createNotFoundException('No product found ' , $id);
        }
        $em->remove($product);
        $em->flush();
        return new Response('Deleted');
    }

    public function pricemoreAction($price) {
        $repository = $this->getDoctrine()->getRepository('AcmeStoreBundle:Product');
        $query = $repository->createQueryBuilder('p')
            ->where('p.price > :price')
            ->setParameter('price', $price)
            ->orderBy('p.price', 'ASC')
            ->getQuery();
        $products = $query->getResult();
        return $this->render('AcmeStoreBundle:Default:all.html.twig', array('products' => $products));
    }
}
