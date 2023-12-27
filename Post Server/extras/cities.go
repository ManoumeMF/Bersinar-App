package extras

import (
	"BSB/BSB/config"
	"BSB/BSB/response"
	"encoding/json"
	"net/http"
)

type Cities struct {
	City_id   int    `gorm:"column:city_id;primary_key:auto_increament" json:"city_id"`
	City_name string `gorm:"column:city_name" json:"city_name"`
}

func ViewAllCities(w http.ResponseWriter, r *http.Request) {
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
	var cities []Cities
	result := DB.Raw("CALL viewAll_cities").Take(&cities)
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Get Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", cities)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}

func ViewCitiesByProvince(w http.ResponseWriter, r *http.Request) {
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
	var cities, temp []Cities
	check := DB.Table("cities").Where("prov_id =?", id).Take(&temp)
	if check.Error != nil {
		res := response.BuildErrorResponse("No Data's Found", "No ID Found", response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	result := DB.Raw("CALL view_cities_byProvinceId(?)", id).Take(&cities)
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Get Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", cities)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}
