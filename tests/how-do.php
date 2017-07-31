<?php

//
// post:
// - title
// - content
//
// post_seo
// - meta_title
// - meta_desc
// - meta_keyswords
//

namespace Domain {

    class Post extends Core\Entity
    {
        public $id;
        public $title;
        public $content;
        public $meta_title;
        public $meta_desc;
        public $meta_keywords;
    }

    class PostRepository
    {
        protected $seoMapper;
        protected $postMapper;

        public function __construct(array $mappers)
        {
            $this->seoMapper = $mappers['PostSeoMapper'];
            $this->postMapper = $mappers['PostMapper'];
        }

        public function createOne(Data\Post $post, Data\PostSeo $postSeo)
        {
            $post = new Domain\Post();
            $post->title = $dataPost->title;
            $post->content = $dataPost->content;
            $post->meta_title = $dataPostSeo->meta_title;
            $post->meta_desc = $dataPostSeo->meta_desc;
            $post->meta_keywords = $dataPostSeo->meta_keywords;

            return $post;
        }

        public function findOne($id): ?Entity
        {
            $dataPost = $this->postMapper->findOne($id);
            $dataPostSeo = $this->seoMapper->findOne(['post_id' => $id]);

            return $dataPost && $dataPostSeo ? $this->createOne($dataPost, $dataPostSeo) : null;
        }
    }

}

namespace Data {

    class Post extends Model
    {
        public $id;
        public $title;
        public $content;
    }

    class PostSeo extends Model
    {
        public $id;
        public $post_id;
        public $meta_title;
        public $meta_desc;
        public $meta_keywords;
    }

    class PostMapper extends Core\PdoMapper
    {
        protected static function getModelClass(): string
        {
            return \Data\Post::class;
        }

        public static function getTableName()
        {
            return 'post';
        }

        public static function getPrimaryKey()
        {
            return 'id';
        }
    }

    class PostSeoMapper extends Core\PdoMapper
    {
        // ...

        public function findByAnyOneColumn(string $value)
        {
            $criteria = new Criteria();
            // ... init criteria
            return $this->findAll($criteria);
        }
    }
}

namespace Core {

    /**
     * Модель
     */
    abstract class Model
    {
        abstract public static function getSchema(): array;
    }

    /**
     * Сущность домена (бизнес-логика, Domain Layer)
     */
    abstract class DomainModel extends Model
    {

    }

    /**
     * Репозиторий (Mapper для домена)
     */
    abstract class Repository
    {
        abstract public function findOne(Criteria $condition): ?DomainModel;

        abstract public function findAll(Criteria $condition): array;

        abstract public function save(DomainModel $model);

        abstract public function delete(DomainModel $model);

        abstract public function deleteAll(Criteria $condition);
    }

    /**
     * Сущность записи (данные, Data Layer)
     */
    abstract class DataModel extends Model
    {

    }

    /**
     * Mapper не содержит информацию о структуре модели
     * Структура хранится в самой модели
     */
    abstract class DataMapper
    {
        public function createModelByRow(array $data): DataModel
        {
            $class = self::getModelClass();
            $model = new $class();
            $model->setValues($row);
            return $model;
        }

        abstract public static function getModelClass(): string;

        abstract public function findOne(Criteria $condition): ?DataModel;

        abstract public function findAll(Criteria $condition): array;

        abstract public function save($model): bool;

        abstract public function delete(DataModel $model): bool;

        abstract public function deleteAll(Criteria $condition): bool;
    }

    abstract class PdoMapper extends Mapper
    {
        protected $dbh;

        public function __construct(PdoConnection $dbh)
        {
            $this->dbh = $dbh;
        }

        abstract public static function getTableName();

        public static function getPrimaryKey()
        {
            return 'id';
        }

        public function findOne(Criteria $condition): ?Model
        {
            // ...
        }

        // ...
    }

    abstract class ArrayMapper extends Mapper
    {
        protected $data;

        public function __construct(array $data)
        {
            $this->dbh = $data;
        }

        public function findOne(Criteria $condition): ?Model
        {
            // ...
        }

        public function findAll(Criteria $condition): array
        {
            // ...
        }
    }

}
