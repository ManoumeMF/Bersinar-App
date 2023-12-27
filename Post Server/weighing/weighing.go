package weighing

import (
	"BSB/BSB/config"
	"BSB/BSB/response"
	"encoding/json"
	"net/http"
)

type WeighingDetails struct {
	ItemId    int     `gorm:"column:itemId" json:"itemId"`
	Weight    float32 `gorm:"column:weight" json:"weight"`
	ItemUoMId int     `gorm:"column:itemUoMId" json:"itemUoMId"`
}

type WeighingInsert struct {
	WeighingId      int               `gorm:"column:weighingId;primary_key:auto_increament" json:"weighingId"`
	WeighingNumCode string            `gorm:"column:weighingNumCode" json:"weighingNumCode"`
	AssignmentId    int               `gorm:"column:assignmentId" json:"assignmentId"`
	DateWeighing    string            `gorm:"column:dateWeighing" json:"dateWeighing"`
	SupplierId      int               `gorm:"column:supplierId" json:"supplierId"`
	BusinessUnitId  int               `gorm:"column:businessUnitId" json:"businessUnitId"`
	PickupDate      string            `gorm:"column:pickupDate" json:"pickupDate"`
	Description     string            `gorm:"column:description" json:"description"`
	CreateBy        string            `gorm:"column:createBy" json:"createBy"`
	DetailWeighing  []WeighingDetails `gorm:"column:detailWeighing" json:"detailWeighing"`
	IsDelete        int               `gorm:"column:isDelete" json:"isDelete"`
}

type WeighingView struct {
	WeighingId          int    `gorm:"column:weighingId" json:"weighingId"`
	WeighingNumCode     string `gorm:"column:weighingNumCode" json:"weighingNumCode"`
	DateWeighing        string `gorm:"column:dateWeighing" json:"dateWeighing"`
	PickupDate          string `gorm:"column:pickupDate" json:"pickupDate"`
	AssignmentLetterNum string `gorm:"column:assignmentLetterNum" json:"assignmentLetterNum"`
	SupplierName        string `gorm:"column:supplierName" json:"supplierName"`
	EmployeeName        string `gorm:"column:employeeName" json:"employeeName"`
	Status              string `gorm:"column:status" json:"status"`
	CreatedBy           string `gorm:"column:createdBy" json:"createdBy"`
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
	var weighing []WeighingView
	result := DB.Raw("CALL viewAll_weighing").Take(&weighing)
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Get Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", weighing)
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
	var weighing, temp WeighingView
	check := DB.Table("weighing").Where("businessUnitId =?", id).Take(&temp)
	if check.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	result := DB.Raw("CALL viewAll_weighing_byBUId(?)", id).Take(&weighing)
	if result.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", weighing)
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
	var weighing, temp WeighingView
	check := DB.Table("weighing").Where("weighingId =?", id).Take(&temp)
	if check.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	result := DB.Raw("CALL viewAll_weighing_byId(?)", id).Take(&weighing)
	if result.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", weighing)
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
	var Weighing WeighingInsert
	err := json.NewDecoder(r.Body).Decode(&Weighing)
	if err != nil {
		res := response.BuildErrorResponse("Failed to Process Request", err.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	DB := config.SetupDBConnection()
	defer config.CloseDBConnection(DB)
	marshalled, _ := json.Marshal(Weighing)
	result := DB.Exec("CALL insert_weighing(?)", string(marshalled))
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Insert Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", Weighing)
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
	var weighing WeighingInsert
	var temp WeighingView
	err := json.NewDecoder(r.Body).Decode(&weighing)
	if err != nil {
		res := response.BuildErrorResponse("Failed to Process Request", err.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	check := DB.Table("weighing").Where("weighingId =?", weighing.WeighingId).Take(&temp)
	if check.Error != nil {
		res := response.BuildErrorResponse("Failed to Process Request", "No Data's Found In Database", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	marshalled, _ := json.Marshal(weighing)
	result := DB.Exec("CALL update_weighing(?)", string(marshalled))
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Update Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", weighing)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}

// func Delete(w http.ResponseWriter, r *http.Request) {
// 	w.Header().Set("Content-Type", "application/json")
// 	if r.Method != http.MethodDelete {
// 		res := response.BuildErrorResponse("Wrong Method", "Wrong Method", response.EmptyObj{})
// 		w.WriteHeader(http.StatusBadRequest)
// 		response, _ := json.Marshal(res)
// 		w.Write(response)
// 		return
// 	}
// 	id := r.URL.Query().Get("id")
// 	DB := config.SetupDBConnection()
// 	defer config.CloseDBConnection(DB)
// 	var temp WeighingView
// 	check := DB.Table("weighing").Where("weighingId =?", id).Take(&temp)
// 	if check.Error != nil {
// 		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
// 		w.WriteHeader(http.StatusBadRequest)
// 		response, _ := json.Marshal(res)
// 		w.Write(response)
// 		return
// 	}
// 	result := DB.Exec("CALL delete_weighing(?)", id)
// 	if result.Error != nil {
// 		res := response.BuildErrorResponse("Cannot Insert Data", result.Error.Error(), response.EmptyObj{})
// 		w.WriteHeader(http.StatusBadRequest)
// 		response, _ := json.Marshal(res)
// 		w.Write(response)
// 		return
// 	}
// 	res := response.BuildResponse(true, "OK!", temp)
// 	w.WriteHeader(http.StatusOK)
// 	response, _ := json.Marshal(res)
// 	w.Write(response)
// 	return
// }
