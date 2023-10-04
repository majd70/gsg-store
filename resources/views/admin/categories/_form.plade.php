<div class="form-group">
            <label for="">Category Name</label>
            <input type="text" class="form-control" name="name" value="{{ $category02->name }}">
        </div>

        <div class="form-group">
            <label for="">Parent</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">No Parent</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}" @if ($parent->id == $category02->parent_id) selected @endif>
                        {{ $parent->name }}</option>
                @endforeach
            </select>

        </div>


        <div class="form-group">
            <label for="">Description</label>
            <textarea class="form-control" name="description">{{ $category02->description }}</textarea>
        </div>


        <div class="form-group">
            <label for="">Image</label>
            <input type="file" class="form-control" name="image">
        </div>


        <div class="form-group">
            <button type="submit" class="btn btn-primary">save</button>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status-active" value="status" @if($category02->status=='active') checked @endif>
                <label class="form-check-label" for="flexRadioDefault1">
                    Active
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status-draft" value="draft"  @if($category02->status=='draft') checked @endif>
                <label class="form-check-label" for="flexRadioDefault2">
                    Draft
                </label>
            </div>

        </div>


    </form>
