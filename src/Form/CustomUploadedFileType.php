<?php

namespace App\Form;

use App\Entity\CustomUploadedFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CustomUploadedFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('file', VichImageType::class, [
                "required" => false,
                'allow_delete' => true,
                'download_uri' => true,
                'download_label' => true,
                'image_uri' => true,
                'asset_helper' => true,
            ])
            ->add('status')
            ->add('fileName')
            ->add('mimeType')
            ->add('fileSize')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CustomUploadedFile::class,
        ]);
    }
}
