package extras

import (
	"BSB/BSB/config"
	"BSB/BSB/response"
	"encoding/json"
	"net/http"
)

type Provinces struct {
	Prov_id   int    `gorm:"column:prov_id;primary_key:auto_increament" json:"prov_id"`
	Prov_name string `gorm:"column:prov_name" json:"prov_name"`
	Location  int    `gorm:"column:location" json:"location"`
	Status    int    `gorm:"column:status" json:"status"`
}

func ViewAllProvince(w http.ResponseWriter, r *http.Request) {
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
	var provinces []Provinces
	result := DB.Raw("CALL viewAll_provinces").Take(&provinces)
	if result.Error != nil {
		res := response.BuildErrorResponse("Cannot Get Data", result.Error.Error(), response.EmptyObj{})
		w.WriteHeader(http.StatusBadRequest)
		response, _ := json.Marshal(res)
		w.Write(response)
		return
	}
	res := response.BuildResponse(true, "OK!", provinces)
	w.WriteHeader(http.StatusOK)
	response, _ := json.Marshal(res)
	w.Write(response)
	return
}
