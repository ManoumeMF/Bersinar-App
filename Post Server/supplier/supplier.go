package supplier

import (
	"BSB/BSB/config"
	"BSB/BSB/response"
	"encoding/json"
	"net/http"
)

type Supplier struct {
	SupplierId        int    `gorm:"column:supplierId;primary_key:auto_increament" json:"supplierId"`
	PartnerTypeId     int    `gorm:"column:partnerTypeId" json:"partnerTypeId"`
	SupplierCode      string `gorm:"column:supplierCode" json:"supplierCode"`
	FullName          string `gorm:"column:fullName" json:"fullName"`
	Sex               string `gorm:"column:sex" json:"sex"`
	BirthPlace        string `gorm:"column:birthPlace" json:"birthPlace"`
	BirthDate         string `gorm:"column:birthDate" json:"birthDate"`
	Email             string `gorm:"column:email" json:"email"`
	MobileNumber      string `gorm:"column:mobileNumber" json:"mobileNumber"`
	WhatsAppNumber    string `gorm:"column:whatsAppNumber" json:"whatsAppNumber"`
	OccupationId      int    `gorm:"column:occupationId" json:"occupationId"`
	MothersName       string `gorm:"column:mothersName" json:"mothersName"`
	BusinessUnitId    int    `gorm:"column:businessUnitId" json:"businessUnitId"`
	ResponsiblePerson string `gorm:"column:responsiblePerson" json:"responsiblePerson"`
	SupplierPhoto     string `gorm:"column:supplierPhoto" json:"supplierPhoto"`
	ParentSupplierId  int    `gorm:"column:parentSupplierId" json:"parentSupplierId"`
	IsDeleted         int    `gorm:"column:isDeleted" json:"isDeleted"`
}

type SupplierByBu struct {
	SupplierId      int    `gorm:"column:supplierId;primary_key:auto_increament" json:"supplierId"`
	SupplierCode    string `gorm:"column:supplierCode" json:"supplierCode"`
	SupplierName    string `gorm:"column:supplierName" json:"supplierName"`
	PartnerType     string `gorm:"column:partnerType" json:"partnerType"`
	SupplierAddress string `gorm:"column:supplierAddress" json:"supplierAddress"`
	MobileNumber    string `gorm:"column:mobileNumber" json:"mobileNumber"`
	WhatsAppNumber  string `gorm:"column:whatsAppNumber" json:"whatsAppNumber"`
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
	var suppliers []SupplierByBu
	result := DB.Raw("CALL viewAll_supplier()").Scan(&suppliers)
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Get Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", suppliers)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}
func ViewById(w http.ResponseWriter, r *http.Request) {
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
	var supplier Supplier
	check := DB.Table("supplier").Where("supplierId =?", id).Take(&supplier)
	if check.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	result := DB.Raw("CALL view_supplier_byId(?)", id).Scan(&supplier)
	if result.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", supplier)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}
func Insert(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "appliation/json; charset=UTF-8")
	if r.Method != http.MethodPost {
		res := response.BuildErrorResponse("Wrong Method", "Wrong Method", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	var supplier Supplier
	err := json.NewDecoder(r.Body).Decode(&supplier)
	if err != nil {
		res := response.BuildErrorResponse("Failed to Process Request", err.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	DB := config.SetupDBConnection()
	defer config.CloseDBConnection(DB)
	marshalled, _ := json.Marshal(supplier)
	result := DB.Exec("CALL insert_supplier(?)", string(marshalled))
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Insert Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", supplier)
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
	var supplier, temp Supplier
	err := json.NewDecoder(r.Body).Decode(&supplier)
	if err != nil {
		res := response.BuildErrorResponse("Failed to Process Request", err.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	check := DB.Table("supplier").Where("supplierId =?", supplier.SupplierId).Take(&temp)
	if check.Error != nil {
		res := response.BuildErrorResponse("Failed to Process Request", "No Data's Found In Database", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	marshalled, _ := json.Marshal(supplier)
	result := DB.Exec("CALL update_supplier(?)", string(marshalled))
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Update Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", supplier)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return

}
func Delete(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json")
	if r.Method != http.MethodDelete {
		res := response.BuildErrorResponse("Wrong Method", "Wrong Method", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	id := r.URL.Query().Get("id")
	DB := config.SetupDBConnection()
	defer config.CloseDBConnection(DB)
	var temp Supplier
	check := DB.Table("supplier").Where("supplierId =?", id).Take(&temp)
	if check.Error != nil || temp.IsDeleted != 0 {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	result := DB.Exec("CALL delete_supplier(?)", id)
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Insert Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	temp.IsDeleted = 1
	res := response.BuildResponse(true, "OK!", temp)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}

func ViewAllByBuId(w http.ResponseWriter, r *http.Request) {
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
	var supplier, temp []Supplier
	check := DB.Table("supplier").Where("businessUnitId =?", id).Take(&temp)
	if check.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	result := DB.Raw("CALL viewAll_supplier_byBUId(?)", id).Scan(&supplier)
	if result.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", supplier)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}

func ViewCombo(w http.ResponseWriter, r *http.Request) {
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
	type tempNasabah struct {
		PartnerTypeId int    `gorm:"column:partnerTypeId;primary_key:auto_increament" json:"partnerTypeId"`
		PartnerType   string `gorm:"column:partnerType" json:"partnerType"`
	}
	var Nasabah []tempNasabah
	result := DB.Raw("CALL cbo_partnerType_Nasabah").Take(&Nasabah)
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Get Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", Nasabah)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}
