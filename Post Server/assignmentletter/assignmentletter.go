package assignmentletter

import (
	"BSB/BSB/config"
	"BSB/BSB/response"
	"encoding/json"
	"net/http"
)

type ViewAssignment struct {
	AssignmentId        int    `gorm:"column:assignmentId;primary_key:auto_increament" json:"assignmentId"`
	AssignmentLetterNum string `gorm:"column:assignmentLetterNum" json:"assignmentLetter"`
	DateCreated         string `gorm:"column:dateCreated" json:"dateCreated"`
	ExpiredDate         string `gorm:"column:expiredDate" json:"expiredDate"`
	EmployeeName        string `gorm:"column:employeeName" json:"employeeName"`
	CreatedBy           string `gorm:"column:createdBy" json:"createdBy"`
}

type InsertAssignment struct {
	AssignmentId              int    `gorm:"column:assignmentId;primary_key:auto_increament" json:"assignmentId"`
	BusinessUnitId            int    `gorm:"column:businessUnitId;primary_key:auto_increament" json:"businessUnitId"`
	BusinessUnitName          string `gorm:"column:businessUnitName;" json:"businessUnitName"`
	AssignmentLetterNum       string `gorm:"column:assignmentLetterNum" json:"assignmentLetterNum"`
	DateCreated               string `gorm:"column:dateCreated" json:"dateCreated"`
	ExpiredDate               string `gorm:"column:expiredDate" json:"expiredDate"`
	AssignedTo                int    `gorm:"column:assignedTo" json:"assignedTo"`
	AssignedToName            string `gorm:"column:assignedToName" json:"assignedToName"`
	VehicleTypeId             int    `gorm:"column:vehicleTypeId" json:"vehicleTypeId"`
	VehicleTypeName           string `gorm:"column:vehicleTypeName" json:"vehicleTypeIdName"`
	VehicleRegistrationNumber string `gorm:"column:vehicleRegistrationNumber" json:"vehicleRegistrationNumber"`
	NeedFor                   string `gorm:"column:needFor" json:"needFor"`
	CreatedBy                 int    `gorm:"column:createBy" json:"createBy"`
	CreatedByName             string `gorm:"column:createdByName" json:"createdByName"`
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
	var AssignmentLetter []ViewAssignment
	result := DB.Raw("CALL viewAll_assignmentLetter()").Scan(&AssignmentLetter)
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Get Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", AssignmentLetter)
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
	var assignmentLetter InsertAssignment
	check := DB.Table("assignmentLetter").Where("assignmentId =?", id).Take(&assignmentLetter)
	if check.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	result := DB.Raw("CALL view_assignmentLetter_byId(?)", id).Scan(&assignmentLetter)
	if result.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", assignmentLetter)
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
	var assignment InsertAssignment
	err := json.NewDecoder(r.Body).Decode(&assignment)
	if err != nil {
		res := response.BuildErrorResponse("Failed to Process Request", err.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	DB := config.SetupDBConnection()
	defer config.CloseDBConnection(DB)
	marshalled, _ := json.Marshal(assignment)
	result := DB.Exec("CALL insert_assignmentLetter(?)", string(marshalled))
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Insert Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", assignment)
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
	var assignmentLetter, temp InsertAssignment
	err := json.NewDecoder(r.Body).Decode(&assignmentLetter)
	if err != nil {
		res := response.BuildErrorResponse("Failed to Process Request", err.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	check := DB.Table("assignmentLetter").Where("assignmentId =?", assignmentLetter.AssignmentId).Take(&temp)
	if check.Error != nil {
		res := response.BuildErrorResponse("Failed to Process Request", "No Data's Found In Database", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	marshalled, _ := json.Marshal(assignmentLetter)
	result := DB.Exec("CALL update_assignmentLetter(?)", string(marshalled))
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Update Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", assignmentLetter)
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
	var temp ViewAssignment
	check := DB.Table("assignmentLetter").Where("assignmentId =?", id).Take(&temp)
	if check.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	result := DB.Exec("CALL delete_assignmentLetter(?)", id)
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Insert Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", temp)
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
	var assignmentLetter, temp []InsertAssignment
	check := DB.Table("assignmentLetter").Where("businessUnitId =?", id).Take(&temp)
	if check.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	result := DB.Raw("CALL viewAll_assignmentLetter_byBUId(?)", id).Scan(&assignmentLetter)
	if result.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", assignmentLetter)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}
