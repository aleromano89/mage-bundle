{{php}}
declare(strict_types=1);

namespace {{namespace}};

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use {{api_namespace}}\Data\{{repository_name}}Interface;
use {{api_namespace}}\Data\{{repository_name}}SearchResultInterface;
use {{api_namespace}}\{{repository_name}}RepositoryInterface;
use {{namespace}}\ResourceModel\{{repository_name}} as {{repository_name}}Resource;
use {{namespace}}\ResourceModel\{{repository_name}}\CollectionFactory as {{repository_name}}CollectionFactory;

class {{repository_name}}Repository implements {{repository_name}}RepositoryInterface
{

    public function __construct(
        protected {{repository_name}}Resource ${{repository_name_argument}}Resource,
        protected {{repository_name}}Factory ${{repository_name_argument}}Factory,
        protected {{repository_name}}CollectionFactory ${{repository_name_argument}}CollectionFactory,
        protected CollectionProcessorInterface $collectionProcessor,
        protected {{repository_name}}SearchResultInterface ${{repository_name_argument}}SearchResult
    ){}

    /**
     * @param $id
     * @return {{repository_name}}Interface
     * @throws NoSuchEntityException
     */
    public function getById($id): {{repository_name}}Interface
    {
        ${{repository_name_argument}} = $this->{{repository_name_argument}}Factory->create();
        $this->{{repository_name_argument}}Resource->load(${{repository_name_argument}}, $id);
        if (!${{repository_name_argument}}->getEntityId()) {
            throw new NoSuchEntityException(__('Entity with id "%1" does not exist.', $id));
        }

        return ${{repository_name_argument}};
    }

    /**
     * @param {{repository_name}}Interface $deliveryBlacklist
     * @return {{repository_name}}Interface
     * @throws CouldNotSaveException
     */
    public function save({{repository_name}}Interface ${{repository_name_argument}}): {{repository_name}}Interface
    {
        try {
            $this->{{repository_name_argument}}Resource->save(${{repository_name_argument}});
            return ${{repository_name_argument}};
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save: %1', $e->getMessage()));
        }
    }

    /**
     * @param DeliveryBlacklistInterface ${{repository_name_argument}}
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete({{repository_name}}Interface ${{repository_name_argument}}): bool
    {
        try {
            $this->{{repository_name_argument}}Resource->delete(${{repository_name_argument}});
            return true;
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete: %1', $e->getMessage()));
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return {{repository_name}}SearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): {{repository_name}}SearchResultInterface
    {
        $collection = $this->{{repository_name_argument}}CollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $this->{{repository_name_argument}}SearchResult->setSearchCriteria($searchCriteria);
        $items = $collection->getItems();
        $this->{{repository_name_argument}}SearchResult->setItems($items);
        $this->{{repository_name_argument}}SearchResult->setTotalCount($collection->getSize());
        return $this->{{repository_name_argument}}SearchResult;
    }
}
