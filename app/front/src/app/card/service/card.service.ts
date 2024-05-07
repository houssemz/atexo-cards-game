import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { Card } from '../model/card';

@Injectable({
  providedIn: 'root',
})
export class CardService {
  constructor(private http: HttpClient) {}

  getCards(size: number): Observable<Card[]> {
    let url = `http://0.0.0.0:8000/api/hand/${size}`;

    return this.http.get<Card[]>(url).pipe(
      catchError((error: { message: string }) => {
        throw 'Error fetching cards: ' + error.message;
      }),
    );
  }

  sortCards(cards: Card[]): Observable<Card[]> {
    let url: string = 'http://0.0.0.0:8000/api/sort';

    return this.http.post<Card[]>(url, cards).pipe(
      catchError((error: { message: string }) => {
        throw 'Error sorting cards: ' + error.message;
      }),
    );
  }
}
