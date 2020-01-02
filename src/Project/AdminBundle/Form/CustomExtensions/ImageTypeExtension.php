<?php


namespace Project\AdminBundle\Form\CustomExtensions;


use Project\Utils\Core\Php\SystemSettings;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;


class ImageTypeExtension extends AbstractTypeExtension
{

    private $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getExtendedType()
    {
        return FileType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // makes it legal for FileType fields to have an image_property option
        $resolver->setDefined(['image_property']);
        $resolver->setDefined(['image_dir_parameter']);
        $resolver->setDefined(['width']);
        $resolver->setDefined(['height']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {

        if (isset($options['image_dir_parameter'])) {
            // this will be whatever class/entity is bound to your form (e.g. Media)
            $parentData = $form->getParent()->getData();

            $imageName= null;
            if (null !== $parentData) {
                $accessor = PropertyAccess::createPropertyAccessor();
                $imageName = $accessor->getValue($parentData, $form->getName());
            }


            if($imageName){

                $sys = $this->container->get(SystemSettings::class);
                $base_url = $sys->getBaseUrl();

                $path = $this->container->getParameter($options['image_dir_parameter']);

                // sets an "image_url" variable that will be available when rendering this field
                $view->vars['image_url'] = "$base_url/$path/".$imageName;
            }

        }
    }

}
