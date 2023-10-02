<?php

namespace App\Repository\Eloquent;

use App\Models\Backend\BillerCategory;
use App\Repository\BillerCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Psr\Log\LogLevel;

class BillerCategoryRepository extends BaseRepository implements BillerCategoryRepositoryInterface
{
    public function __construct(BillerCategory $model)
    {
        parent::__construct($model);
    }

    public function findCategory($id)
    {
        return BillerCategory::find($id);
    }

//    public function store(FormDualAuth $dualAuth)
//    {
//        switch ($dualAuth->method) {
//            case FormDualAuth::METHOD_CREATE:
//                return $this->createCategory($dualAuth);
//            case FormDualAuth::METHOD_UPDATE:
//                return $this->update($dualAuth);
//            default:
//                log_activity('Store pending change', 'Store pending update ' . $dualAuth->id . '. Failed: Unimplemented method handle.', null, LogLevel::WARNING);
//
//        }
//    }

//    public function update(FormDualAuth $dualAuth)
//    {
//        $oldData = json_decode($dualAuth->old_payload, true);
//        $newData = json_decode($dualAuth->new_payload, true);
//        try {
//            $category = $this->storeCategoryUpdate($oldData["id"], json_decode(json_encode($newData["data"]), true));
//
//            $printData = filter_arrays($oldData, json_decode(json_encode($newData), true)["data"]);
//
//            audit_log(AuditTrailAction::EDIT_BILLER_CATEGORY->name, "Provider category " . $oldData["id"] . ", updated successfully.", json_encode($printData[0]), json_encode($printData[1]));
//
//            event(new DualAuthApproved($dualAuth));
//            return $dualAuth;
//        } catch (\Exception $exception) {
//            log_activity('Store pending change', 'Store pending update ' . $dualAuth->id . '. Exception: ' . $exception->getMessage(), null, LogLevel::WARNING);
//        }
//    }

    public function getActiveCategories(): Collection|array
    {
        return BillerCategory::query()->select(['id', 'name'])->where('category_status', BillerCategory::ACTIVE)->get();
    }

//    private function createCategory(FormDualAuth $dualAuth)
//    {
//        $payload = json_decode($dualAuth->new_payload);
//        try {
//            $newCategoryData = json_decode(json_encode($payload->data), true);
//            $category = $this->storeCategory($newCategoryData);
//
//            audit_log(AuditTrailAction::ADD_BILLER_CATEGORY->name, "Provider category " . $newCategoryData["name"] . ", saved successfully.", null, json_encode($newCategoryData));
//
//            event(new DualAuthApproved($dualAuth));
//            return $dualAuth;
//        } catch (\Exception $exception) {
//            log_activity('Store pending change', 'Store pending update ' . $dualAuth->id . '. Exception: ' . $exception->getMessage() . ' - ' . $exception->getLine(), null, LogLevel::WARNING);
//        }
//    }

    public function storeCategory(array $data)
    {
        return BillerCategory::create($data);
    }

    public function storeCategoryUpdate(int $id, array $data)
    {
        return BillerCategory::find($id)->update($data);
    }
}
