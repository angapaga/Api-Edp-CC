import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

@Injectable()

export class PostService {
  server: string = 'http://192.168.0.201/Api-Edp-CC/';

  constructor(private httpClient: HttpClient) {}

//   postData(body, file): Observable<any>{
//     let type = 'application/json; charset=utf-8';
//     //let headers = new HttpHeaders({ 'Content-Type': type });
//     let headers = new HttpHeaders({ 'Content-Type': 'application/json; charset=utf-8' });
//     //let options = new HttpRequestOptions({ headers: headers });

//     return this.httpClient.post(this.server + file, JSON.stringify(body), headers)
//     .pipe(
//     map(res => res));
// }

  postData(body:any, file:any): Observable<any> {
    const url = this.server + file;
    let headers = new HttpHeaders({ 'Content-Type': 'application/json; charset=utf-8' });

    return this.httpClient.post(url, JSON.stringify(body), { headers })
            .pipe(map((res: any) => res));
  }
}