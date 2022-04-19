package service;

import entite.guide_touristique;
import entite.reservation_guide;

public interface IreservationGuide <t>{
	
	void insert(reservation_guide t);
	void update(reservation_guide t, int id); 
	void delete(int id); 


}
