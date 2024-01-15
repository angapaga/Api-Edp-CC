import { Injectable } from '@angular/core';
import { Storage } from '@ionic/storage';

@Injectable({
  providedIn: 'root'
})
export class DataService {
  private periodo: any;

  constructor(private storage: Storage) { 
    this.storage.create();
    this.storage.get('periodo').then((valor) => {
      this.periodo = valor;
    });
  }

  getPeriodo(): any {
    return this.periodo;
  }

  setPeriodo(nuevoValor: any): void {
    this.periodo = nuevoValor;
    this.storage.set('periodo', nuevoValor);
  }
}
