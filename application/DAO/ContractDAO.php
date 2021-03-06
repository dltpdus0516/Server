<?php

namespace DAO;
use Model\ContractModel;

include_once("../application/lib/autoload.php");

class ContractDAO extends BaseDAO
{
    protected $tableName = "contract";

    /**
     * @param ContractModel $contractModel
     * @return false|int|null
     */
    public function insert(ContractModel $contractModel){
        $penalty =  str_replace ("'", "\'", $contractModel->getPenalty());

        $query = "INSERT INTO {$this->tableName} (
                    title,
                    borrow_date,
                    payback_date,
                    price,
                    lender_id,
                    lender_name,
                    lender_bank,
                    lender_account,
                    penalty,
                    content,
                    alarm,
                    created_at
                    ) VALUES (
                    '{$contractModel->getTitle()}',
                    '{$contractModel->getBorrowDate()}',
                    '{$contractModel->getPaybackDate()}',
                    {$contractModel->getPrice()},
                    {$contractModel->getLenderId()},
                    '{$contractModel->getLenderName()}',
                    '{$contractModel->getLenderBank()}',
                    {$contractModel->getLenderAccount()},
                    '{$penalty}',
                    '{$contractModel->getContent()}',
                    {$contractModel->getAlarm()},
                    {$contractModel->getCreatedAt()})";

        $this->db->executeQuery($query);
        return $this->db->getInsertId();
    }

    /**
     * @param ContractModel $contractModel
     * @return false|int|null
     */
    public function insertContent(ContractModel $contractModel){

        $query = "INSERT INTO {$this->tableName} (
                    content
                    ) VALUES (
                    '{$contractModel->getContent()}'";

        $this->db->executeQuery($query);
        return $this->db->getInsertId();
    }

    /**
     * @param $id
     * @return ContractModel
     */
    public function selectbyId($id){
        $query = "SELECT * FROM {$this->tableName} WHERE id like {$id}";
        $this->db->executeQuery($query);
        return $this->db->getResultAsObject(new ContractModel());
    }

    /**
     * @param $userId
     * @return ContractModel
     */
    public function selectByUserId($user_id){
        $query = "select * from {$this->tableName} where lender_id={$user_id}";
        $this->db->executeQuery($query);
        return $this->db->getAllResultAsObject(new ContractModel());
    }

    /**
     * @param $id int
     * @param ContractModel $contractModel
     * @return int|null
     */
    public function updateContractInfo($id, ContractModel $contractModel){

        $penalty =  str_replace ("'", "\'",$contractModel -> getPenalty());

        $query = "UPDATE {$this->tableName} SET title='{$contractModel->getTitle()}', borrow_date='{$contractModel->getBorrowDate()}',
                    payback_date='{$contractModel->getPaybackDate()}',price={$contractModel->getPrice()}, lender_id = {$contractModel->getLenderId()} 
                    ,lender_name='{$contractModel->getLenderName()}',content='{$contractModel->getContent()}', penalty='{$penalty}',alarm={$contractModel->getAlarm()}, 
                    updated_at={$contractModel->getUpdatedAt()} where id={$id}";

        $this->db->executeQuery($query);
        return $this->stmt->rowCount();
    }

    /**
     * @param ContractModel $contractModel
     * @return false|int|null
     */
    public function updatePaybackState($id,$state){

        $query = "UPDATE {$this->tableName} SET state={$state} where id={$id}";

        $this->db->executeQuery($query);
        return $this->stmt->rowCount();
    }

    /**
     * @param $id int
     * @return int|null
     */
    public function delete($id){
        $query = "delete from {$this->tableName} where id = {$id};";
        $this->db->executeQuery($query);
        return $this->stmt->rowCount();
    }

}

?>