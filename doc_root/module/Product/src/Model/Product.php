<?php

namespace Product\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;
use Zend\Validator\Between;

/**
 * 商品モデルクラス。
 * zend-db の TableGateway クラスで動作させるために、 exchangeArray() メソッドを実装する。
 */
class Product implements InputFilterAwareInterface
{
    /** @var null|int $id */
    public ?int $id;
    /** @var null|string $itemName */
    public ?string $itemName;
    /** @var null|int $price */
    public ?int $price;
    /** @var null|string $image */
    public ?string $image;

    /** @var $inputFilter */
    private $inputFilter;

    /**
     * 指定した配列からデータをエンティティのプロパティにコピーする。
     * (zend-db の TableGateway クラスで動作させるため)
     *
     * @param array $data
     * @return void
     */
    public function exchangeArray(array $data)
    {
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->itemName = isset($data['item_name']) ? $data['item_name'] : null;
        $this->price = isset($data['price']) ? $data['price'] : null;
        $this->image = isset($data['image']) ? $data['image'] : null;
    }

    /**
     * InputFilterAwareInterfaceでは、setInputFilter()とgetInputFilter()という2つのメソッドが定義されており、
     * getInputFilter()のみを実装すればよいので、setInputFilter()からは例外を投げる。
     *
     * @param \Zend\InputFilter\InputFilterInterface $inputFilter
     * @return void
     * @throws DomainException
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    /**
     * InputFilter のインスタンスを作成。フィルタリングやバリデーションを行うプロパティごとに設定。
     *
     * @return InputFilterInterface $inputFilter
     */
    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true, // 必須項目として設定
            'filters' => [
                ['name' => ToInt::class], // int フィルタを追加し、整数値のみを使用
            ],
        ]);

        $inputFilter->add([
            'name' => 'item_name',
            'required' => true, // 必須項目として設定
            // StripTagsとStringTrimという2つのフィルタを追加して、不要なHTMLや不要な空白を削除。
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            // データベースに格納できる文字数以上の文字をユーザーが入力しないように StringLength バリデーターを追加。
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 85,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'price',
            'required' => true, // 必須項目として設定
            'filters' => [
                // int フィルタを追加し、整数値のみを使用
                ['name' => ToInt::class],
                // StripTagsとStringTrimという2つのフィルタを追加して、不要なHTMLや不要な空白を削除。
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    // 指定した値が他の2つの値の間にあるかどうか
                    'name' => Between::class,
                    'options' => [
                        'min' => 1,
                        'max' => 100000000, // 8桁までOK
                    ],
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}
