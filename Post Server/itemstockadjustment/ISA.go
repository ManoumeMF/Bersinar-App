package itemstockadjustment

import (
	"BSB/BSB/config"
	"BSB/BSB/response"
	"encoding/json"
	"net/http"
)

type ISAView struct {
	ItemStockAdjId int    `gorm:"column:itemStockAdjId;primary_key:auto_increament" json:"itemStockAdjId"`
	DateAdjustment string `gorm:"column:dateAdjustment" json:"dateAdjustment"`
	Description    string `gorm:"column:description" json:"description"`
	ProcessedBy    string `gorm:"column:processedBy" json:"processedBy"`
}

type ISADetails struct {
	ItemId                int    `gorm:"column:itemId;primary_key:auto_increament" json:"itemId"`
	WarehouseId           int    `gorm:"column:warehouseId" json:"warehouseId"`
	StockAdjustmentAmount int    `gorm:"column:stockAdjustmentAmount" json:"stockAdjustmentAmount"`
	AdjustmentReason      string `gorm:"column:adjustmentReason" json:"adjustmentReason"`
}

type ISAInsert struct {
	ItemStockAdjId   int          `gorm:"column:itemStockAdjId;primary_key:auto_increament" json:"itemStockAdjId"`
	DateAdjustment   string       `gorm:"column:dateAdjustment" json:"dateAdjustment"`
	Description      string       `gorm:"column:description" json:"description"`
	ProcessedBy      string       `gorm:"column:processedBy" json:"processedBy"`
	TimeAdjustment   int          `gorm:"column:timeAdjustment" json:"timeAdjustment"`
	StockAdjustments []ISADetails `gorm:"column:stockAdjustments" json:"stockAdjustments"`
}

func ViewAllISA(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json; charset=UTF-8")
	if r.Method != http.MethodGet {
		res := response.BuildErrorResponse("Wrong Method", "Wrong Method", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	DB := config.SetupDBConnection()
	defer config.CloseDBConnection(DB)
	var ISA []ISAView
	result := DB.Raw("CALL viewAll_itemStockAdjustment").Take(&ISA)
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Get Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", ISA)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}
func ViewISAByBuId(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "appliation/json; charset=UTF-8")
	if r.Method != http.MethodGet {
		res := response.BuildErrorResponse("Wrong Method", "Wrong Method", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	id := r.URL.Query().Get("id")
	DB := config.SetupDBConnection()
	defer config.CloseDBConnection(DB)
	var ISA, temp ISAView
	check := DB.Table("itemStockAdjustment").Where("businessUnitId =?", id).Take(&temp)
	if check.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	result := DB.Raw("CALL viewAll_itemStockAdjustment_byBUId(?)", id).Take(&ISA)
	if result.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", ISA)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}
func InsertISA(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "appliation/json; charset=UTF-8")
	if r.Method != http.MethodPost {
		res := response.BuildErrorResponse("Wrong Method", "Wrong Method", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	var ISA ISAInsert
	err := json.NewDecoder(r.Body).Decode(&ISA)
	if err != nil {
		res := response.BuildErrorResponse("Failed to Process Request", err.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	DB := config.SetupDBConnection()
	defer config.CloseDBConnection(DB)
	marshalled, _ := json.Marshal(ISA)
	result := DB.Exec("CALL insert_itemStockAdjustment(?)", string(marshalled))
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Insert Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", ISA)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}
