package purchaseorder

import (
	"BSB/BSB/config"
	"BSB/BSB/response"
	"encoding/json"
	"net/http"
)

type ViewOrder struct {
	PurchaseOrderId  int    `gorm:"column:purchaseOrderId;primary_key:auto_increament" json:"purchaseOrderId"`
	PurchaseOrderNum string `gorm:"column:purchaseOrderNum" json:"purchaseOrderNum"`
	DateCreated      string `gorm:"column:dateCreated" json:"dateCreated"`
	ItemReceiptNum   string `gorm:"column:itemReceiptNum" json:"itemReceiptNum"`
	WeighingNumCode  string `gorm:"column:weighingNumCode" json:"weighingNumCode"`
	SupplierName     string `gorm:"column:supplierName" json:"supplierName"`
	Status           string `gorm:"column:status" json:"status"`
	CreatedBy        string `gorm:"column:createdBy" json:"createdBy"`
}

type OrderDetails struct {
	ItemId              int     `gorm:"column:itemId;primary_key:auto_increament" json:"itemId"`
	ItemUoMId           int     `gorm:"column:itemUoMId" json:"itemUoMId"`
	Weight              float64 `gorm:"column:weight" json:"weight"`
	ItemPurchasePriceId int     `gorm:"column:itemPurchasePriceId" json:"itemPurchasePriceId"`
	ItemPurchasePrice   float64 `gorm:"column:itemPurchasePrice" json:"itemPurchasePrice"`
	IsPercentDiscount   int     `gorm:"column:isPercentDiscount" json:"isPercentDiscount"`
	DiscountAmount      float64 `gorm:"column:discountAmount" json:"discountAmount"`
	IsPercentTax        int     `gorm:"column:isPercentTax" json:"isPercentTax"`
	TaxAmount           float64 `gorm:"column:taxAmount" json:"taxAmount"`
}

type InsertOrder struct {
	PurchaseOrderId     int            `gorm:"column:purchaseOrderId;primary_key:auto_increament" json:"purchaseOrderId"`
	BusinessUnitId      int            `gorm:"column:businessUnitId;primary_key:auto_increament" json:"businessUnitId"`
	PurchaseOrderNum    string         `gorm:"column:purchaseOrderNum" json:"purchaseOrderNum"`
	DateCreated         string         `gorm:"column:dateCreated" json:"dateCreated"`
	PoSendDate          string         `gorm:"column:poSendDate" json:"poSendDate"`
	ItemReceiptId       int            `gorm:"column:itemReceiptId;primary_key:auto_increament" json:"itemReceipt"`
	IdPaymentType       int            `gorm:"column:idPaymentType" json:"idPaymentType"`
	IdCurrency          int            `gorm:"column:idCurrency" json:"idCurrency"`
	Description         string         `gorm:"column:description" json:"description"`
	IsPercentTax        int            `gorm:"column:isPercentTax" json:"isPercentTax"`
	TaxAmount           string         `gorm:"column:taxAmount" json:"taxAmount"`
	DeliveryCost        string         `gorm:"column:deliveryCost" json:"deliveryCost"`
	PoStatusId          int            `gorm:"column:poStatusId" json:"poStatusId"`
	CreatedBy           string         `gorm:"column:createdBy" json:"createdBy"`
	DetailPurchaseOrder []OrderDetails `gorm:"column:detailPurchaseOrder" json:"detailPurchaseOrder"`
}

func ViewAll(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "appliation/json; charset=UTF-8")
	if r.Method != http.MethodGet {
		res := response.BuildErrorResponse("Wrong Method", "Wrong Method", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	DB := config.SetupDBConnection()
	defer config.CloseDBConnection(DB)
	var purchaseOrder []ViewOrder
	result := DB.Raw("CALL viewAll_purchaseOrder").Take(&purchaseOrder)
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Get Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", purchaseOrder)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}
func ViewByBuId(w http.ResponseWriter, r *http.Request) {
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
	var purchaseOrder, temp ViewOrder
	check := DB.Table("purchaseOrder").Where("purchaseOrderId =?", id).Take(&temp)
	if check.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	result := DB.Raw("CALL viewAll_purchaseOrder_byBUId(?)", id).Take(&purchaseOrder)
	if result.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", purchaseOrder)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}
func Insert(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json; charset=UTF-8")
	if r.Method != http.MethodPost {
		res := response.BuildErrorResponse("Wrong Method", "Wrong Method", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	var purchaseOrder InsertOrder
	err := json.NewDecoder(r.Body).Decode(&purchaseOrder)
	if err != nil {
		res := response.BuildErrorResponse("Failed to Process Request", err.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	DB := config.SetupDBConnection()
	defer config.CloseDBConnection(DB)
	marshalled, _ := json.Marshal(purchaseOrder)
	result := DB.Exec("CALL insert_purchaseOrder(?)", string(marshalled))
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Insert Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", purchaseOrder)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}
func Update(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "appliation/json; charset=UTF-8")
	if r.Method != http.MethodPut {
		res := response.BuildErrorResponse("Wrong Method", "Wrong Method", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	DB := config.SetupDBConnection()
	defer config.CloseDBConnection(DB)
	var purchaseOrder InsertOrder
	var temp ViewOrder
	err := json.NewDecoder(r.Body).Decode(&purchaseOrder)
	if err != nil {
		res := response.BuildErrorResponse("Failed to Process Request", err.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	check := DB.Table("purchaseOrder").Where("purchaseOrderId =?", purchaseOrder.PurchaseOrderId).Take(&temp)
	if check.Error != nil {
		res := response.BuildErrorResponse("Failed to Process Request", "No Data's Found In Database", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	marshalled, _ := json.Marshal(purchaseOrder)
	result := DB.Exec("CALL update_purchaseOrder(?)", string(marshalled))
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Update Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", purchaseOrder)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}
