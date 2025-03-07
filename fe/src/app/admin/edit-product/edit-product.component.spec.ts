import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminEditProductComponent } from './edit-product.component';

describe('EditProductComponent', () => {
  let component: AdminEditProductComponent;
  let fixture: ComponentFixture<AdminEditProductComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AdminEditProductComponent]
    })
      .compileComponents();

    fixture = TestBed.createComponent(AdminEditProductComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
