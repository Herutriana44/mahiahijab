import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TambahKategoriComponent } from './tambah-kategori.component';

describe('TambahKategoriComponent', () => {
  let component: TambahKategoriComponent;
  let fixture: ComponentFixture<TambahKategoriComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [TambahKategoriComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(TambahKategoriComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
