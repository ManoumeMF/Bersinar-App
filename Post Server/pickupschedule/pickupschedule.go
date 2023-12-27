package pickupschedule

import (
	"BSB/BSB/config"
	"BSB/BSB/response"
	"encoding/json"
	"net/http"
)

type PickupPlaces struct {
	SupplierId int `gorm:"column:itemId" json:"supplierId"`
}

type WeighingInsert struct {
	PickupScheduleid int          `gorm:"column:weighingId;primary_key:auto_increament" json:"pickupScheduleid"`
	BusinessUnitId   string       `gorm:"column:weighingNumCode" json:"businessUnitId"`
	IsReguler        int          `gorm:"column:assignmentId" json:"isReguler"`
	PickupDate       string       `gorm:"column:dateWeighing" json:"pickupDate"`
	StartHour        int          `gorm:"column:supplierId" json:"startHour"`
	EndHour          int          `gorm:"column:businessId" json:"endHour"`
	PickupOfficer    string       `gorm:"column:pickupDate" json:"pickupOfficer"`
	CreateBy         string       `gorm:"column:createBy" json:"createBy"`
	Description      string       `gorm:"column:description" json:"description"`
	PickupPlaces     PickupPlaces `gorm:"column:detailWeighing" json:"pickupPlaces"`
	IsDelete         int          `gorm:"column:isDelete" json:"isDelete"`
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
	var weighing []WeighingInsert
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
	var weighing, temp WeighingInsert
	check := DB.Table("weighing").Where("weighingId =?", id).Take(&temp)
	if check.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	result := DB.Raw("CALL view_weighing_byId(?)", id).Take(&weighing)
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
	var Pickup WeighingInsert
	err := json.NewDecoder(r.Body).Decode(&Pickup)
	if err != nil {
		res := response.BuildErrorResponse("Failed to Process Request", err.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	DB := config.SetupDBConnection()
	defer config.CloseDBConnection(DB)
	marshalled, _ := json.Marshal(Pickup)
	result := DB.Exec("CALL insert_pickupSchedule(?)", string(marshalled))
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Insert Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", Pickup)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return

}
