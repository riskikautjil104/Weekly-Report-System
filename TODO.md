# TODO (Requirements Feature)

- [ ] Step 1: Create migrations for `requirements` and `requirement_comments` tables.
- [ ] Step 2: Add Eloquent models: `Requirement`, `RequirementComment` (+ relationships).
- [ ] Step 3: Implement controllers:
  - [ ] `RequirementController` (index, create/store, show, status update by admin, print/PDF endpoint)
  - [ ] `RequirementCommentController` (store comment; allow both roles)
- [ ] Step 4: Add routes in `routes/web.php` (user & admin capabilities + print route).
- [ ] Step 5: Create Blade views:
  - [ ] `requirements/index.blade.php`
  - [ ] `requirements/create.blade.php`
  - [ ] `requirements/show.blade.php` (includes comment thread + comment form)
  - [ ] `requirements/print.blade.php` (print-friendly view)
- [ ] Step 6: Update navigation/sidebar so both admin & user can access the new feature.
- [ ] Step 7: Add feature tests (commenting + access control + print route).
- [x] Step 1: Create migrations for `requirements` and `requirement_comments` tables.
- [x] Step 2: Add Eloquent models: `Requirement`, `RequirementComment` (+ relationships).
- [x] Step 3: Implement controllers:
  - [x] `RequirementController` (index, create/store, show, admin status update, print/PDF endpoint)
  - [x] `RequirementCommentController` (store comment; allow both roles)
- [x] Step 4: Add routes in `routes/web.php` (user & admin capabilities + print route).
- [x] Step 5: Create Blade views:
  - [x] `requirements/index.blade.php`
  - [x] `requirements/create.blade.php`
  - [x] `requirements/show.blade.php` (includes comment thread + comment form)
  - [x] `requirements/print.blade.php` (print-friendly view; browser print-to-PDF)
- [x] Step 6: Update navigation/sidebar so both admin & user can access the new feature.
- [ ] Step 7: Add feature tests (commenting + access control + print route).
- [x] Step 8: Run migrations and test locally.


