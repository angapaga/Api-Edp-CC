import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class PostService {
  server: string = 'http://192.168.0.101/Api-Edp-CC/';

  constructor(private httpClient: HttpClient) {}

  postData(body:any, file:any): Observable<any> {
    const url = this.server + file;
    const headers = new HttpHeaders({ 'Content-Type': 'application/json; charset=utf-8' });

    return this.httpClient.post(url, JSON.stringify(body), { headers })
      .pipe(
        map(res => res)
      );
  }
}