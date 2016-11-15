<?php
/************************************************************
** @Description: 基础model类
** @Author: haodaquan
** @Date:   2016-11-14
** @Last Modified by:   haodaquan
** @Last Modified time: 2016-11-14
*************************************************************/

namespace Pipi\Library;
use Pipi\Library\Database\Pdo as Pdos;

class Model
{
    protected $model;
    protected $table;
    protected $fields = '*';
    protected $order  = '';
    protected $limit  = '';

    protected $where  = '';

    protected $data   = [];
    public    $debug  = 0;#获取sql语句 0-不输出，1-输出sql语句
    public    $sqlLog = [];#记录sql语句
    public    $errorInfo = '';

    /**
     * [__construct 初始化方法]
     * @param string $table    [表名]
     * @param string $database [数据库名]
     */
    public function __construct($table='',$database='DB_DEFAULT')
    {
        $this->table = $table;

        $this->model = Pdos::getInstance(C($database));
    }


    /**
     * [select 查询方法]
     * @return [type] [description]
     */
    public function select()
    {
        $sql  = 'SELECT ';
        $sql .= $this->fields;
        $sql .= ' FROM '.$this->table;
        $sql .= $this->where ? ' WHERE '.$this->where : ''; 
        $sql .= $this->order ? ' ORDER BY '.$this->order : '';
        $sql .= $this->limit ? ' LIMIT '.$this->limit : '';

        $this->sqlLog[] = $sql; 
        if($this->debug===1) return $sql;
        $res  = $this->model->query($sql);
        $res->setFetchMode(C('FETCH_TYPE'));
        $data = $res->fetchAll();
        return $data;
    }



    public function add()
    {
        $sql    = 'INSERT INTO ';
        $sql   .= $this->table;

        $keys   = '';
        $values = '';
        foreach ($this->data as $key => $value) {
            $keys   .= '`'.$key.'`,';
            $values .= '"'.$value.'",';
        }

        $keys   = rtrim($keys,',');
        $values = rtrim($values,',');
        
        $sql .= '('.rtrim($keys,',').')';
        $sql .= ' VALUES('.$values.')';

        $this->model->exec($sql);
        if($this->debug===1) return $sql;
        $this->sqlLog[] = $sql; 
        return $this->model->lastInsertId(); 
    }

    /**
     * [save 修改]
     * @return [type] [影响条数0-n OR false]
     */
    public function save()
    {
        $sql    = 'UPDATE ';
        $sql   .= $this->table;
        $sql   .= ' SET ';
        foreach ($this->data as $key => $value) {
            $sql    .= '`'.$key.'`="'.$value.'",';
        }
        $sql    = rtrim($sql,',');
        $sql   .= ' WHERE '.$this->where;
        if (!$this->where) return false;
        if($this->debug===1) return $sql;
        $this->sqlLog[] = $sql; 
        $res = $this->model->exec($sql);
        $this->errorInfo();
        return $res;
    }
    /**
     * [delete description]
     * @return [type] [false 或影响条数]
     */
    public function delete()
    {
        $sql    = 'DELETE FROM ';
        $sql   .= $this->table;
        $sql   .= ' WHERE '.$this->where;
        if (!$this->where) return false;
        if($this->debug===1) return $sql;
        $this->sqlLog[] = $sql; 
        return $this->model->exec($sql);
    }
    
    /**
     * [sqlQuery 执行原生sql]
     * @param  [type] $sql [description]
     * @return [type]      [description]
     */
    public function sqlQuery($sql)
    {
        if($this->debug===1) return $sql;
        $this->sqlLog[] = $sql; 
        if (strpos(strtolower($sql),'select')===false) {
            $res = $this->model->query($sql);
            $res->setFetchMode(C('FETCH_TYPE'));
            return $res->fetchAll();
        }else
        {
            return $this->model->exec($sql);
        }
    }

    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    public function fields($fields="*")
    {
        $this->fields = $fields;
        return $this;
    }

    public function order($order='')
    {
        $this->order = $order;
        return $this;
    }

    public function limit($limit='')
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * [where 条件]
     * @param  string $where [字符串]
     * @return [type]        [description]
     */
    public function where($where='')
    {
        $this->where = $where;
        return $this;
    }


    ###############################
    #
    # 调试方法 开始
    #
    ###############################
    /**
     * [fetchSql 获取sql语句]
     * @return [type] [对象本身]
     */
    public function fetchSql()
    {
        $this->debug = 1;
        return $this;
    }

    /**
     * [lastSql 获取最后一条sql语句]
     * @return [string] [sql语句]
     */
    public function lastSql()
    {
        return end($this->sqlLog);
    }

    /**
     * [sqlLog 获取全部sql语句]
     * @return [array] [sql语句一维数组]
     */
    public function sqlLog()
    {
        return $this->sqlLog;
    }

    /**
     * [errorInfo 获取错误信息]
     * @return [type] [description]
     */
    public function errorInfo()
    {
        return $this->errorInfo[] = Pdos::getError();
    }

    ###############################
    #
    # 调试方法 结束
    #
    ###############################
}